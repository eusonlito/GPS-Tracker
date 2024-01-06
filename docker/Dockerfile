FROM php:8.3

RUN apt-get update -y
RUN apt-get upgrade -y

RUN apt install -yqq --no-install-recommends \
    cron default-mysql-client git \
    libbz2-dev libicu-dev libldb-dev libonig-dev \
    libxslt-dev libzip-dev procps unzip

RUN rm -rf /var/lib/apt/lists/*

RUN apt clean && apt autoclean && apt autoremove --assume-yes

RUN pecl install redis

RUN docker-php-ext-install bcmath bz2 intl mbstring opcache pdo_mysql pcntl sockets xsl zip
RUN docker-php-ext-enable redis

COPY ./docker/php.ini /usr/local/etc/php/

COPY ./docker/crontab /etc/cron.d/crontab

RUN crontab -u www-data /etc/cron.d/crontab

USER www-data

WORKDIR /app

COPY --chown=www-data:www-data ./ /app

RUN ./composer install --no-dev --optimize-autoloader --classmap-authoritative

RUN php artisan key:generate

USER root

CMD ["./docker/init.sh"]
