FROM composer:latest AS composer

FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    openssl \
    git \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install pdo pdo_mysql mbstring zip

COPY composer.lock composer.json /var/www/

COPY database /var/www/database

WORKDIR /var/www

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . /var/www

RUN composer install --no-interaction

RUN chown -R www-data:www-data /var/*
RUN chmod -R 755 /var/www/* 

RUN php artisan optimize