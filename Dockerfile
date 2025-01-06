# Dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www/html

# Copy CI4 files into container
COPY . .

# Set permissions for writable folder
RUN chown -R www-data:www-data /var/www/html/writable
