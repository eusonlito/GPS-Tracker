FROM --platform=${BUILDPLATFORM:-"linux/amd64"} php:8.1.15 as build

COPY --from=composer:2.5.1 /usr/bin/composer /usr/local/bin/composer

RUN --mount=type=cache,sharing=locked,target=/var/cache/apt \
    apt-get update && \
    apt-get install -yqq --no-install-recommends \
    git libzip-dev zip unzip && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install zip

WORKDIR /app

COPY . /app

RUN --mount=type=cache,sharing=locked,target=/root/.composer \
    COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi

RUN mkdir -p storage/logs/laravel

FROM php:8.1.15-apache
COPY --from=composer:2.5.1 /usr/bin/composer /usr/local/bin/composer

# use unprivileged port
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:8080/g' /etc/apache2/sites-available/000-default.conf

# fix docroot, as our app is served from ./public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# cleanup apache modules
RUN rm -fv /etc/apache2/mods-enabled/* && \
      a2enmod authz_core alias dir mpm_prefork negotiation php headers rewrite

RUN --mount=type=cache,sharing=locked,target=/var/cache/apt \
    apt-get update && \
    apt-get install -yqq --no-install-recommends \
    default-mysql-client libzip-dev cron && rm -rf /var/lib/apt/lists/*

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

RUN docker-php-ext-install pdo_mysql zip && docker-php-ext-enable pdo_mysql

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

WORKDIR /var/www/html

COPY --from=build --chown=33:33 /app /var/www/html

COPY docker/entrypoint.sh /

COPY docker/crontab /etc/cron.d/crontab

RUN crontab -u www-data /etc/cron.d/crontab \
    && chmod u+s /usr/sbin/cron

EXPOSE 8091
EXPOSE 8080

USER 33

ENTRYPOINT ["/entrypoint.sh"]
