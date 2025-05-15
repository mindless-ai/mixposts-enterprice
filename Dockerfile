# Build stage
FROM composer:2 as composer
FROM node:18 as build

WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./
COPY auth.json ./

# Install PHP dependencies
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-scripts --no-autoloader

# Copy the rest of the application code
COPY . .

# Install and build frontend assets
RUN npm ci && \
    npm run build && \
    composer dump-autoload --optimize

# Production stage
FROM php:8.2-fpm

WORKDIR /app

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Copy application files from build stage
COPY --from=build /app /app

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Clear Laravel caches
RUN php artisan route:clear && \
    php artisan cache:clear && \
    php artisan config:clear && \
    php artisan view:clear

EXPOSE 9000

CMD ["php-fpm"]
