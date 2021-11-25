FROM php:8.0-fpm-alpine

# Install dependencies
RUN set -eux \
    && apk update \
    && apk add --no-cache \
        unzip \
        nodejs \
        npm

# https://github.com/mlocati/docker-php-extension-installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync \
    && install-php-extensions @composer \
    gd \
    pdo_mysql \
    intl

WORKDIR /var/www/html/

CMD ["php-fpm"]

EXPOSE 9000