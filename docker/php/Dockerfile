FROM php:7.3-apache

WORKDIR /app

RUN a2enmod rewrite
RUN docker-php-ext-install pdo_mysql mbstring json mysqli