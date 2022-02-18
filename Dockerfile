FROM php:7.2-fpm
RUN apt-get update && apt-get install -y git unzip

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions zip pdo_mysql intl
