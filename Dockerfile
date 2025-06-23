# === Stage 1: Build composer dependencies ===
FROM composer:2.7 as vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-scripts --no-interaction --optimize-autoloader

# Copy the rest of the application code
COPY . .

# === Stage 2: PHP runtime ===
FROM php:8.3-fpm-alpine as app

# Install system dependencies
RUN apk add --no-cache \
    bash \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    zlib-dev \
    curl \
    git \
    unzip \
    tzdata \
    netcat-openbsd && \
    docker-php-ext-install pdo pdo_mysql zip intl opcache && \
    cp /usr/share/zoneinfo/Asia/Jakarta /etc/localtime && echo "Asia/Jakarta" > /etc/timezone

# Copy application source
WORKDIR /var/www

COPY --from=vendor /app /var/www
COPY --from=vendor /app/vendor /var/www/vendor

#Hapus cache config lama yang kebawa dari host
RUN rm -rf bootstrap/cache/*.php

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Make sure storage and bootstrap/cache exist with proper permissions
RUN mkdir -p /var/www/storage/logs /var/www/bootstrap/cache && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Switch to non-root
USER www-data

ENTRYPOINT ["/entrypoint.sh"]