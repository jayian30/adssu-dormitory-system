FROM php:8.2-apache

# Install PDO MySQL extension for database connectivity
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite module for clean URLs
RUN a2enmod rewrite

# Copy all project files to the default Apache directory
COPY . /var/www/html/

# Expose port 80
EXPOSE 80
