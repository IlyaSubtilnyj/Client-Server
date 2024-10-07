FROM php:8.2-fpm
RUN apt update \
    && apt install -y git libicu-dev libzip-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install intl \
    && pecl install apcu \
    && docker-php-ext-enable apcu

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN git config --global user.mail "i0treret@gmail.com" \
    && git config --global user.name "Ilya Gonzarevich"

WORKDIR /var/www/app
