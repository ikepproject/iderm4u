# Use the official PHP image as a parent image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the contents of the application directory to /var/www/html
COPY . /var/www/html

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN chown -R www:data-www:data /var/www/html
RUN chmod -R 775 /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite
