FROM php:7.4-fpm-alpine

RUN apk update && \
    apk add --no-cache pcre-dev $PHPIZE_DEPS postgresql-dev && \
    pecl install -o -f redis xdebug && \
    rm -rf /tmp/pear && \
    docker-php-ext-install pdo pdo_pgsql && \
    docker-php-ext-enable redis xdebug && \
    apk del $PHPIZE_DEPS

COPY ./conf.d /usr/local/etc/php/conf.d

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN addgroup -g 1000 www && adduser -u 1000 -s /bin/ash -G www www -D

USER www

EXPOSE 9000

WORKDIR /app

CMD ["php-fpm"]