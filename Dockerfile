# syntax=docker/dockerfile:1
#
# iDerm4U — PHP 8.5 / CodeIgniter 4.7
#
# Topology is unchanged from the previous UBI9 image:
#   nginx (separate host, TLS + geofence)
#     -> this container :8080 (Caddy)
#        -> php-fpm 127.0.0.1:9000 (CI4 front controller)
#
# Caddy is the only thing serving files, and it runs an allowlist:
# /public/** as static (minus .php), everything else into index.php.

# ==================================================================
# Stage 1 — resolve PHP dependencies
# ==================================================================
# Nothing from this stage ships except vendor/ and composer.lock.
# The result is cached, so editing app code never re-resolves deps.
FROM composer:2.8 AS vendor

WORKDIR /app

# Dependency resolution.
#
# composer.json is always copied. composer.lock is copied when present so a
# committed, current lock makes the build reproducible. The committed lock in
# this repo still pins codeigniter4/framework v4.3.2, which does not satisfy
# the ^4.7 constraint, so `composer install` refuses it — the RUN below detects
# that and resolves fresh instead of failing the build.
#
# Once a correct lock is committed, every later build is reproducible. To
# capture the lock this stage produces:
#   docker run --rm --entrypoint cat <image> /application/composer.lock > composer.lock
COPY composer.json ./
COPY composer.lock* ./

# ext-intl / ext-mbstring are ignored at resolve time because the resolver
# container does not carry CI4's platform extensions. The RUNTIME image
# genuinely provides both, so this only affects version selection.
# No shell variables here on purpose. In a Dockerfile RUN, "$$FLAGS" is a
# collision: Docker's parser escapes "$$" to "$", but /bin/sh expands "$$" to
# the shell PID, so the flags became "1FLAGS" and Composer tried to install
# packages literally named "1flags". Writing the flags out inline is dull but
# cannot go wrong.
RUN set -e; \
    if [ -f composer.lock ] && \
       composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist \
         --ignore-platform-req=ext-intl --ignore-platform-req=ext-mbstring; then \
      echo '>>> installed from composer.lock (reproducible)'; \
    else \
      echo '>>> composer.lock missing or stale - resolving fresh with -W'; \
      composer update -W --no-dev --optimize-autoloader --no-interaction --prefer-dist \
        --ignore-platform-req=ext-intl --ignore-platform-req=ext-mbstring; \
    fi

# ==================================================================
# Stage 2 — runtime
# ==================================================================
# Pinned, not floating. php:8.5-fpm-bookworm tracks whatever is newest, which
# makes builds non-reproducible and could silently pull an unpatched runtime.
# 8.5.12 is the release that fixes CVE-2026-109618 / CVE-2026-109619 (PHP2Shell).
FROM php:8.5.12-fpm-bookworm

# Fail the build loudly rather than shipping a vulnerable runtime.
# PHP2Shell = CVE-2026-109618 + CVE-2026-109619, CVSS v4.0 9.2, unauthenticated
# RCE in the PHP engine itself, exploited in the wild from 2026-10-17.
# Fixed in 8.5.12 / 8.4.27 / 8.3.36 / 8.2.35. PHP 7.4, 8.0 and 8.1 are EOL and
# receive no upstream fix at all.
RUN php -r 'if (PHP_VERSION_ID < 80512) { fwrite(STDERR, "FATAL: PHP " . PHP_VERSION . " predates 8.5.12 and is vulnerable to CVE-2026-109618 / CVE-2026-109619 (PHP2Shell).\n"); exit(1); } echo "PHP " . PHP_VERSION . " - patched for PHP2Shell.\n";'

# --- PHP extensions -----------------------------------------------------------
RUN apt-get update && apt-get install -y --no-install-recommends \
      libpq-dev \
      libpng-dev libjpeg62-turbo-dev libfreetype6-dev libwebp-dev \
      libzip-dev libicu-dev \
      unzip ca-certificates \
 && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-install -j"$(nproc)" pdo_pgsql gd intl opcache zip \
 && apt-get purge -y --auto-remove \
 && rm -rf /var/lib/apt/lists/*

# git is intentionally NOT installed — only stage 1 needs it for --prefer-dist.

# --- Caddy (pinned static binary, no repo juggling) ---------------------------
ARG CADDY_VERSION=2.8.4
RUN curl -sSL "https://github.com/caddyserver/caddy/releases/download/v${CADDY_VERSION}/caddy_${CADDY_VERSION}_linux_amd64.tar.gz" \
      | tar -xz -C /usr/bin caddy \
 && chmod +x /usr/bin/caddy

# --- User BEFORE COPY so ownership is correct from the start ------------------
RUN useradd -ms /bin/bash iderm4u

WORKDIR /application

# App source first, then vendor on top, so the resolved stage always wins.
COPY . .
COPY --from=vendor /app/vendor          /application/vendor
COPY --from=vendor /app/composer.lock   /application/composer.lock

RUN chown -R iderm4u:iderm4u /application

# --- php-fpm pool -------------------------------------------------------------
# Runs as iderm4u; listens on loopback only. Caddy is the sole client.
RUN rm -f /usr/local/etc/php-fpm.d/www.conf \
 && printf '%s\n' \
      '[www]' \
      'user = iderm4u' \
      'group = iderm4u' \
      'listen = 127.0.0.1:9000' \
      '' \
      'pm = dynamic' \
      'pm.max_children = 20' \
      'pm.start_servers = 4' \
      'pm.min_spare_servers = 4' \
      'pm.max_spare_servers = 8' \
      'pm.max_requests = 500' \
      '' \
      'catch_workers_output = yes' \
      'decorate_workers_output = no' \
      > /usr/local/etc/php-fpm.d/www.conf

# --- php.ini ------------------------------------------------------------------
# display_errors=Off is defence in depth. It does NOT replace CI_ENVIRONMENT=production,
# because Boot/development.php calls ini_set('display_errors','1') at runtime.
RUN printf '%s\n' \
      'expose_php = Off' \
      'display_errors = Off' \
      'memory_limit = 256M' \
      'upload_max_filesize = 20M' \
      'post_max_size = 20M' \
      'max_execution_time = 120' \
      'date.timezone = Asia/Jakarta' \
      'opcache.enable = 1' \
      'opcache.enable_cli = 0' \
      'opcache.memory_consumption = 256' \
      'opcache.interned_strings_buffer = 16' \
      'opcache.max_accelerated_files = 20000' \
      'opcache.validate_timestamps = 1' \
      'opcache.revalidate_freq = 2' \
      > /usr/local/etc/php/conf.d/iderm4u.ini

EXPOSE 8080
ENTRYPOINT ["supervisord", "-c", "/application/supervisord.conf"]