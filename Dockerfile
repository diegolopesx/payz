FROM php:7.4.10-fpm

RUN apt-get update
RUN apt-get install --no-install-recommends --quiet -y git \
            libicu-dev \
        libcurl4-openssl-dev \
        libzip-dev \
        libbz2-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxml2-dev \
        libtidy-dev \
        zlib1g-dev \
        libxml2-dev \
        libonig-dev \
        libmagickwand-dev \
        libsodium-dev \ 
        unzip \
        gcc make autoconf libc-dev pkg-config
RUN pecl install imagick
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql mysqli curl dom exif fileinfo json mbstring sodium opcache xml zip iconv filter simplexml
RUN rm -rf /var/lib/apt/lists/*
RUN apt-get clean