FROM php:8.1-fpm-buster

RUN apt-get update -y
RUN apt-get upgrade -y

RUN apt install -y apt-utils cron git gnupg2 htop libbz2-dev libicu-dev \
    libldb-dev libmagickwand-dev libxslt-dev libzip-dev \
    mariadb-client procps unzip vim

RUN pecl install imagick redis

RUN docker-php-ext-install bcmath bz2 intl opcache pdo_mysql xsl zip
RUN docker-php-ext-enable imagick redis

COPY ./docker/php.ini /usr/local/etc/php/

WORKDIR /app

COPY ./ /app

RUN cp -n ./docker/.env .

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN composer install --no-dev --optimize-autoloader --classmap-authoritative

RUN php artisan key:generate

RUN install -d storage/logs/artisan
RUN touch storage/logs/artisan/schedule-run.log

COPY ./docker/cronjob /etc/cron.d/cronjob

CMD ["./docker/init.sh"]
