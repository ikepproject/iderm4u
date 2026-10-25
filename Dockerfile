# Use UBI9 as base image
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
RUN dnf module install -y php:remi-7.4 && dnf --enablerepo=remi install -y php-intl php-pgsql php-gd

# Install Composer
RUN mkdir -p /composer/bin/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/composer/bin/ --filename=composer

# Copy your PHP CodeIgniter 4 application into the Docker image
COPY . /application

# Set the working directory
WORKDIR /application

# Install dependencies
RUN /composer/bin/composer install

# create user here !
RUN useradd -ms /bin/bash iderm4u

# EXPOSE
EXPOSE 8080
ENTRYPOINT ["supervisord", "-c", "./supervisord.conf"]