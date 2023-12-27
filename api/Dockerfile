# FROM php:8.1-apache
# 
# RUN apt-get update && apt-get upgrade -y
# 
# # Install PHP extensions
# RUN docker-php-ext-install mysqli pdo pdo_mysql
# RUN docker-php-ext-enable mysqli pdo pdo_mysql
# 
# RUN a2enmod rewrite
# 
# COPY . /var/www/html
# 
# WORKDIR /var/www/html
# 
# RUN chown -R www-data:www-data /var/www/html/
# 
# EXPOSE 80
# 
# CMD ["apache2-foreground"]


FROM php:8.1-apache

# Update and upgrade system packages
RUN apt-get update && apt-get upgrade -y

# Install necessary dependencies for zip and unzip/7z
RUN apt-get install -y libzip-dev zlib1g-dev libbz2-dev

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql zip
RUN docker-php-ext-enable mysqli pdo pdo_mysql zip

# Install unzip/7z
RUN apt-get install -y unzip p7zip-full

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer require --dev phpunit/phpunit ^9

# Install git
RUN apt-get install -y git

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Adjust file permissions
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
