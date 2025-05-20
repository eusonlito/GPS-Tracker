FROM php:8.4

RUN apt-get update && apt-get upgrade -y

RUN apt install -yqq --no-install-recommends \
    cron default-mysql-client git \
    libbz2-dev libicu-dev libldb-dev libonig-dev \
    libxslt-dev libzip-dev procps psmisc unzip vim

RUN rm -rf /var/lib/apt/lists/*

RUN apt clean && apt autoclean && apt autoremove --assume-yes

RUN pecl install redis

RUN docker-php-ext-install bcmath bz2 intl mbstring opcache pdo_mysql pcntl sockets xsl zip
RUN docker-php-ext-enable redis

COPY ./docker/php.ini /usr/local/etc/php/
COPY ./docker/crontab /etc/cron.d/crontab

RUN chmod 0600 /etc/cron.d/crontab

WORKDIR /app

COPY  ./ /app

RUN echo ":set noshowmode" >> $HOME/.vimrc

RUN git config --global --add safe.directory /app

RUN COMPOSER_ALLOW_SUPERUSER=1 ./composer install --no-dev --optimize-autoloader --classmap-authoritative --no-scripts

CMD ["./docker/init.sh"]
