FROM php:7.3-apache

WORKDIR /app

RUN a2enmod rewrite
RUN docker-php-ext-install pdo_mysql
#CMD ["php", "/app/script/migration.php"]