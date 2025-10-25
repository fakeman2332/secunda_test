FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
    build-base \
    linux-headers \
    libzip-dev \
    zip \
    mariadb-client \
    && docker-php-ext-install pdo_mysql bcmath zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN addgroup -g 1000 www && \
    adduser -u 1000 -G www -s /bin/sh -D www

USER www
