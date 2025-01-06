FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \ 
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Set working directory
WORKDIR /var/www/html

# Copy CI4 files into container
COPY . .

# Set permissions for writable folder
RUN mkdir -p /var/www/html/writable && chown -R www-data:www-data /var/www/html/writable

# Expose port 9000 for PHP-FPM
EXPOSE 9000
