FROM php:7.4-cli-alpine

WORKDIR /var/www/html

RUN apk update && \
    apk add --no-cache pcre-dev $PHPIZE_DEPS postgresql-dev composer && \
    pecl install -o -f redis && \
    rm -rf /tmp/pear && \
    docker-php-ext-install pdo pdo_pgsql && \
    docker-php-ext-enable redis && \
    apk del $PHPIZE_DEPS

ENV COMPOSER_MEMORY_LIMIT -1

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN addgroup -g 1000 www && adduser -u 1000 -s /bin/ash -G www www -D

USER www

WORKDIR /app
