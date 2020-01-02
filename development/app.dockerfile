FROM composer:latest AS composer

FROM php:7.2-fpm

COPY composer.lock composer.json /var/www/

COPY database /var/www/database

WORKDIR /var/www

RUN apt-get update && apt-get -y install git && apt-get -y install zip && apt-get install -y libmcrypt-dev libmagickwand-dev --no-install-recommends

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . /var/www

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN pecl install mcrypt-1.0.2
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-enable mcrypt

RUN mv .env.prod .env

RUN composer install

RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan key:generate
RUN php artisan migrate
RUN php artisan storage:link
RUN php artisan db:seed
RUN php artisan optimize

#RUN php artisan serve