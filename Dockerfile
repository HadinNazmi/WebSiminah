# ==========================================
# Stage 1: Build Frontend Assets (Vite)
# ==========================================
FROM node:20-alpine AS frontend
WORKDIR /app

# Install dependencies first for layer caching
COPY package*.json ./
RUN npm ci

# Copy source and build
COPY . .
RUN npm run build

# ==========================================
# Stage 2: PHP-FPM Production Environment
# ==========================================
FROM php:8.2-fpm

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        bcmath \
        zip \
        gd \
        intl \
        opcache \
        exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure Opcache for production
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.save_comments=1'; \
    echo 'opcache.fast_shutdown=1'; \
} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Configure PHP settings for Laravel
RUN { \
    echo 'upload_max_filesize=32M'; \
    echo 'post_max_size=32M'; \
    echo 'memory_limit=256M'; \
    echo 'max_execution_time=60'; \
} > /usr/local/etc/php/conf.d/laravel-custom.ini

# Install Composer binary from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first to leverage Docker layer caching
COPY composer.json composer.lock ./

# Install vendor packages without autoloader and scripts
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader --prefer-dist

# Copy entire application code
COPY . .

# Copy compiled frontend assets from Stage 1
COPY --from=frontend /app/public/build ./public/build

# Generate optimized Composer autoloader
RUN composer dump-autoload --optimize --no-dev

# Prepare required storage subdirectories and set permissions for www-data
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/app/public \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
