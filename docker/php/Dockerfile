FROM php:7.4.9-fpm-alpine3.12

ENV APCU_VERSION 5.1.18
ENV XDEBUG_VERSION 2.9.6
ENV COMPOSER_VERSION 2.0.9

RUN apk add --update --no-cache \
        bash \
        ca-certificates \
        git \
        icu-libs \
        libxml2-dev \
        unzip \
        zip \
        oniguruma-dev \
        libzip-dev \
        postgresql-dev && \
    apk add --update --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev && \
    pecl install apcu-${APCU_VERSION} xdebug-${XDEBUG_VERSION} && \
    docker-php-ext-install intl zip && \
    docker-php-ext-enable apcu opcache xdebug && \
    docker-php-ext-install -j$(nproc) pgsql && \
    docker-php-ext-install -j$(nproc) pdo_pgsql && \
    apk del .build-deps && \
    apk add gosu --update --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/testing/ && \
    addgroup bar && \
    adduser -D -h /home -s /bin/bash -G bar foo

RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin --version=${COMPOSER_VERSION}

ADD entrypoint.sh /entrypoint
COPY conf/php.ini /usr/local/etc/php/php.ini
COPY conf/xdebug.ini /usr/local/etc/php/conf.d/debug.ini

WORKDIR /srv
ENTRYPOINT ["/entrypoint"]
