FROM php:8.2-fpm

# Instala dependencias básicas
RUN apt-get update && apt-get install -y \
    git zip unzip curl libicu-dev libonig-dev libzip-dev libxml2-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
