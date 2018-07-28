FROM php:7.2-fpm

RUN apt-get update && apt-get install -y git zlib1g-dev libicu-dev && apt-get clean
RUN docker-php-ext-install zip pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /usr/share/nginx/html