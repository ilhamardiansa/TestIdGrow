# Gunakan image PHP-FPM untuk Laravel
FROM php:8.2-fpm-alpine

# Install extension dan tools yang dibutuhkan Laravel
RUN apk add --no-cache \
        bash \
        zip \
        unzip \
        curl \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        icu-dev \
        oniguruma-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        intl \
        zip \
        gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files ke container
COPY . /var/www

# Set permissions untuk storage & bootstrap/cache
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Jalankan optimize Laravel (Autoload dan Cache)
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose port PHP-FPM (default 9000)
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]
