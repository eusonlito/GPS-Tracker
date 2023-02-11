FROM php:8.1

RUN apt-get update -y
RUN apt-get upgrade -y

RUN apt install -yqq --no-install-recommends \
    cron default-mysql-client \
    libbz2-dev libicu-dev libldb-dev libonig-dev \
    libxslt-dev libzip-dev procps unzip

RUN rm -rf /var/lib/apt/lists/*

RUN apt clean && apt autoclean && apt autoremove --assume-yes

RUN pecl install redis

RUN docker-php-ext-install bcmath bz2 intl mbstring opcache pdo_mysql pcntl sockets xsl zip
RUN docker-php-ext-enable redis

COPY ./docker/php.ini /usr/local/etc/php/

COPY --from=composer:2.5 /usr/bin/composer /usr/local/bin/composer

COPY ./docker/crontab /etc/cron.d/crontab

RUN crontab -u www-data /etc/cron.d/crontab
RUN cron

USER www-data

WORKDIR /app

COPY --chown=www-data:www-data ./ /app

RUN cp -n ./docker/.env .

RUN composer install --no-dev --optimize-autoloader --classmap-authoritative

RUN php artisan key:generate

CMD ["./docker/init.sh"]
