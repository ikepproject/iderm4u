# Use UBI9 as base image
#
# The base image does NOT change. The UBI9 + EPEL + Remi + COPR(caddy)
# stack is what already runs in production, and swapping it is what broke
# the previous attempts. The only PHP change is the version below.
FROM registry.access.redhat.com/ubi9/ubi

# add more repository
RUN dnf -y install \
    https://dl.fedoraproject.org/pub/epel/epel-release-latest-9.noarch.rpm \
    https://rpms.remirepo.net/enterprise/remi-release-9.rpm \
    'dnf-command(copr)'
RUN dnf copr enable -y @caddy/caddy

# install the supporting applications
RUN dnf install -y unzip caddy supervisor

# Install PHP and necessary PHP extensions
#
# 7.4 -> 8.4 is the whole PHP-side change. 8.4.27 is the release that
# fixes CVE-2026-109618 / CVE-2026-109619 (PHP2Shell, CVSS 9.2
# pre-auth RCE in the PHP engine). PHP 7.4 receives NO patch at all, so
# there is nothing to upgrade to on 7.4 — the migration is the only fix.
#
# php-mbstring is listed explicitly: CodeIgniter 4.7 declares
# ext-mbstring as a hard requirement, and Composer's platform check
# fails the build if it is missing. It was previously satisfied only
# implicitly by the module's default profile.
RUN dnf module install -y php:remi-8.4 && dnf --enablerepo=remi install -y php-intl php-pgsql php-gd php-mbstring

# Fail the build loudly rather than shipping a vulnerable runtime.
# PHP2Shell = CVE-2026-109618 + CVE-2026-109619, CVSS v4.0 9.2,
# unauthenticated RCE in the PHP engine itself, exploited in the wild
# from 2026-10-17. Fixed in 8.2.35 / 8.3.36 / 8.4.27 / 8.5.12.
# PHP 7.4, 8.0 and 8.1 are EOL and get no fix, so rolling back to the
# old image is not a safe option.
RUN php -r 'if (PHP_VERSION_ID < 80427) { fwrite(STDERR, "FATAL: PHP " . PHP_VERSION . " predates 8.4.27 and is vulnerable to CVE-2026-109618 / CVE-2026-109619 (PHP2Shell).\n"); exit(1); } echo "PHP " . PHP_VERSION . " - patched for PHP2Shell.\n";'

# Make a missing extension visible. If any of these is absent, the
# application fails at runtime with a confusing error; failing the build
# instead turns a 12-hour debugging session into a 1-second one.
RUN php -r 'foreach (["intl","mbstring","pgsql","gd"] as $e) { if (! extension_loaded($e)) { fwrite(STDERR, "FATAL: required PHP extension missing: {$e}\n"); exit(1); } printf("%-10s OK\n", $e); }'

# Install Composer
RUN mkdir -p /composer/bin/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/composer/bin/ --filename=composer

# Copy your PHP CodeIgniter 4 application into the Docker image
COPY . /application

# Set the working directory
WORKDIR /application

# Install dependencies
#
# `update -W` rather than `install`, because composer.lock in the repo
# pins codeigniter4/framework v4.3.2 while composer.json asks for ^4.7 —
# a stale lock makes `composer install` refuse outright, and a partial
# update cannot move a package that is locked to a specific version.
# The -W (--with-all-dependencies) is what allows that move.
#
# No shell variables here on purpose. In a Dockerfile RUN, "$$FLAGS" is a
# collision: Docker's parser escapes "$$" to "$", but /bin/sh expands
# "$$" to the shell PID, so the flags became "1FLAGS" and Composer tried
# to install packages literally named "1flags".
RUN /composer/bin/composer update -W --no-interaction --prefer-dist

# Validate the Caddyfile at BUILD time, not at container start.
#
# A missing binary or a typo in the Caddyfile otherwise surfaces only
# when someone tries to run the container — the image builds perfectly
# and only explodes on first boot. This must come after COPY, because
# the file it checks has to exist by then.
RUN set -eux; \
    test -f /application/Caddyfile || { echo "FATAL: Caddyfile not copied"; exit 1; }; \
    command -v caddy >/dev/null || { echo "FATAL: caddy missing from PATH"; exit 1; }; \
    command -v supervisord >/dev/null || { echo "FATAL: supervisord missing from PATH"; exit 1; }; \
    caddy validate --config /application/Caddyfile --adapter caddyfile; \
    echo ">>> entrypoints and Caddyfile OK"

# create user here !
RUN useradd -ms /bin/bash iderm4u

# EXPOSE
EXPOSE 8080
ENTRYPOINT ["supervisord", "-c", "./supervisord.conf"]
