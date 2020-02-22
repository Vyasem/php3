FROM php:7.3-apache

WORKDIR /app
RUN a2enmod rewrite
RUN docker-php-ext-install pdo_mysql && pecl install xdebug && docker-php-ext-enable xdebug
#CMD ["php", "/app/script/migration.php"]