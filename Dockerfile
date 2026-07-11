FROM php:8.2-apache

# Install MySQL extension for PHP
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy your code to the Apache web directory
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 10000 (Render's default)
EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]