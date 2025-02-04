FROM php:8.2-fpm

# Instalacja zależności systemowych
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Instalacja rozszerzeń PHP
RUN docker-php-ext-install pdo pdo_mysql zip gd intl mbstring exif pcntl bcmath opcache

# Instalacja Composera
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Katalog roboczy
WORKDIR /var/www/html