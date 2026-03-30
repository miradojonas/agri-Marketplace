# ═══════════════════════════════════════════════
# Stage 1 — Build frontend assets (Node)
# ═══════════════════════════════════════════════
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci

COPY vite.config.js ./
COPY resources/ resources/

RUN npm run build

# ═══════════════════════════════════════════════
# Stage 2 — PHP dependencies (Composer)
# ═══════════════════════════════════════════════
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

# ═══════════════════════════════════════════════
# Stage 3 — Production image (PHP-FPM)
# ═══════════════════════════════════════════════
FROM php:8.2-fpm-alpine

# Install system deps + PHP extensions
RUN apk update && apk add --no-cache \
        nginx \
        supervisor \
        curl \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        oniguruma-dev \
        libzip-dev \
        icu-dev \
        mysql-client \
        postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# PHP production config
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/opcache.ini "$PHP_INI_DIR/conf.d/opcache.ini"
COPY docker/php/app.ini "$PHP_INI_DIR/conf.d/app.ini"

# Nginx config
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Supervisor config
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

WORKDIR /var/www/html

# Copy application code
COPY . .

# Copy built assets from frontend stage
COPY --from=frontend /app/public/build public/build

# Copy vendor from composer stage
COPY --from=composer /app/vendor vendor

# Entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Create necessary directories & set permissions
RUN mkdir -p \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data \
        storage \
        bootstrap/cache \
        public/build

EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
