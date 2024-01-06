FROM ubuntu:22.04

ARG DEBIAN_FRONTEND=noninteractive
ENV TZ=Asia/Bangkok
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Update Ubuntu Software repository
RUN apt-get update

# Install PHP
RUN apt -y install software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update
RUN apt -y install php7.4 php7.4-cli php7.4-json php7.4-common php7.4-mysql php7.4-zip php7.4-gd php7.4-mbstring php7.4-curl php7.4-xml php7.4-bcmath php7.4-intl
RUN apt -y install unzip curl supervisor

# Install Composer
RUN mkdir -p /composer/bin
RUN curl -sS https://getcomposer.org/installer -o ./composer-setup.php
RUN php ./composer-setup.php --install-dir=/composer/bin --filename=composer

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



