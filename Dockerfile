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

# EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]


# # === Stage 1: Build dependencies ===
# FROM composer:2.7 as vendor

# WORKDIR /app

# # Copy composer files
# COPY composer.json composer.lock ./

# # Copy the entire application (needed for artisan commands)
# COPY . .

# # Install dependencies
# RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

# # === Stage 2: Runtime image ===
# FROM php:8.3-fpm-alpine as app

# # Install system dependencies
# RUN apk add --no-cache \
#     git \
#     curl \
#     libpng-dev \
#     oniguruma-dev \
#     libxml2-dev \
#     zip \
#     unzip \
#     mysql-client \
#     postgresql-dev \
#     freetype-dev \
#     libjpeg-turbo-dev \
#     libzip-dev \
#     icu-dev \
#     tzdata

# # Install PHP extensions
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg
# RUN docker-php-ext-install \
#     pdo_mysql \
#     pdo_pgsql \
#     mbstring \
#     exif \
#     pcntl \
#     bcmath \
#     gd \
#     zip \
#     opcache

# # Set working directory
# WORKDIR /var/www/html

# # Copy application from vendor stage
# COPY --from=vendor /app /var/www/html

# # Set timezone
# RUN cp /usr/share/zoneinfo/Asia/Jakarta /etc/localtime && echo "Asia/Jakarta" > /etc/timezone

# # Clean up any cached files that might cause issues
# RUN rm -rf bootstrap/cache/*.php

# # Create necessary directories with proper structure
# RUN mkdir -p storage/app/public \
#     storage/framework/cache/data \
#     storage/framework/sessions \
#     storage/framework/views \
#     storage/logs \
#     bootstrap/cache

# # Set ownership and permissions BEFORE switching user
# RUN chown -R www-data:www-data /var/www/html \
#     && chmod -R 775 storage \
#     && chmod -R 775 bootstrap/cache \
#     && chmod -R 755 /var/www/html

# # Create .env file if it doesn't exist
# RUN if [ ! -f .env ]; then cp .env.example .env; fi

# # Generate application key
# RUN php artisan key:generate --no-interaction

# # Clear and cache for production (optional - can be done at runtime)
# RUN php artisan config:clear \
#     && php artisan route:clear \
#     && php artisan view:clear

# # Configure PHP-FPM (make sure these files exist)
# COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
# COPY docker/php/php.ini /usr/local/etc/php/php.ini

# # Copy entrypoint script if you have one
# COPY entrypoint.sh /entrypoint.sh
# RUN chmod +x /entrypoint.sh

# # Expose port 9000 for PHP-FPM
# EXPOSE 9000

# # Switch to non-root user
# USER www-data

# # Use entrypoint if you have initialization tasks
# ENTRYPOINT ["/entrypoint.sh"]

# CMD ["php-fpm"]