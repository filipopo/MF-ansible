ARG PHP_VER=8.4
FROM php:${PHP_VER}-fpm-alpine AS base

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY templates/webserver/website .

RUN export APP_ENV=prod APP_DEBUG=0 && \
    composer install --no-dev --optimize-autoloader && \
    composer dump-env prod && rm -f .env

FROM php:${PHP_VER}-fpm-alpine

COPY --from=base /var/www/html /var/www/html

EXPOSE 9000

CMD ["sh", "-c", "ADMIN_PASSWORD=${ADMIN_PASSWORD} php bin/console doctrine:migrations:migrate -n; php-fpm"]
