FROM php:8.2-fpm-alpine

# Add PHP dependencies
RUN apk add --update \
    bzip2-dev \
    curl-dev \
    oniguruma-dev \
    libxml2-dev \
    libsodium-dev \
    libzip-dev \
    jpeg-dev \
    libpng-dev

## Add PHP extensions
RUN apk add --no-cache $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install zip pdo_mysql pcntl exif gd
    RUN apk add --no-cache $PHPIZE_DEPS \
        && docker-php-ext-configure gd --with-jpeg \
        && docker-php-ext-install zip pdo_mysql pcntl exif gd

## Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

## Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

VOLUME /app

COPY start /start
RUN chmod +x /start
ENTRYPOINT ["/start"]
