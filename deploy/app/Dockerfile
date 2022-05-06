FROM php:7.2.34-fpm-buster

RUN apt update

RUN apt-get clean

RUN apt-get update -y && apt-get upgrade -y \
    && apt-get install -y --no-install-recommends git zlib1g-dev libpng-dev libxml2-dev libonig-dev \
    libfreetype6-dev libjpeg62-turbo-dev libzip-dev unzip ssh-client libc-client-dev libkrb5-dev \
    libldap2-dev libicu-dev procps \
    && apt-get clean

RUN docker-php-ext-install bcmath gd json mbstring mysqli pdo_mysql xml zip intl \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /bin/composer


RUN mkdir /.composer && chmod 0777 /.composer


RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" &&\
    sed -i -e 's/^;date.timezone.*/date.timezone = "Europe\/Moscow"/' "$PHP_INI_DIR/php.ini" &&\
    sed -i -e 's/^memory_limit.*/memory_limit = -1/' "$PHP_INI_DIR/php.ini" &&\
    sed -i -e 's/^upload_max_filesize.*/upload_max_filesize = 50M/' "$PHP_INI_DIR/php.ini" &&\
    sed -i -e 's/^post_max_size.*/post_max_size = 128M/' "$PHP_INI_DIR/php.ini"

COPY . /app/

RUN chmod -R 777 /app/runtime

RUN rm -rf /app/.git
RUN rm -rf /app/.env
RUN rm -rf /app/.idea
RUN rm -rf /app/*.sql

WORKDIR /app
