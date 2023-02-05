#!/bin/bash

DEFAULT_ADMIN_MAIL=${DEFAULT_ADMIN_MAIL:-"admin@local.host"}
DEFAULT_ADMIN_NAME=${DEFAULT_ADMIN_NAME:-"Admin"}
DEFAULT_ADMIN_PASS=${DEFAULT_ADMIN_PASS:-"Admin123"}
DEFAULT_ADMIN_CREATE=${DEFAULT_ADMIN_CREATE:-"false"}

cd /var/www/html

(
    source .env.example
    grep '=' .env.example | cut -d'=' -f1 | while read -r var; do eval echo "$var=\${APP_$var:-\$$var}"; done
) > .env

while ! mysqladmin ping -h"${APP_DB_HOST}" --silent; do
    echo "Waiting for MySQL (host: ${APP_DB_HOST}) to come up.."
    sleep 5
done

php artisan key:generate

composer artisan-cache

php artisan timezone:geojson

yes "yes" | php artisan migrate --path=database/migrations;
yes "yes" | php artisan db:seed --class=Database\\Seeders\\Database;

if [ ! -z "${DEFAULT_LANGUAGE}" ]
then
    mysql \
        -u${APP_DB_USERNAME} \
        -p${APP_DB_PASSWORD} \
        -h${APP_DB_HOST} \
        ${APP_DB_DATABASE} \
        -e 'UPDATE `language` SET `default` = 0;'

    mysql \
        -u${APP_DB_USERNAME} \
        -p${APP_DB_PASSWORD} \
        -h${APP_DB_HOST} \
        ${APP_DB_DATABASE} \
        -e 'UPDATE `language` SET `default` = 1 WHERE `code` = "'${DEFAULT_LANGUAGE}'";'
fi

if [ ! -z "${DEFAULT_TIMEZONE}" ]
then
    mysql \
        -u${APP_DB_USERNAME} \
        -p${APP_DB_PASSWORD} \
        -h${APP_DB_HOST} \
        ${APP_DB_DATABASE} \
        -e 'UPDATE `timezone` SET `default` = 0;'

    mysql \
        -u${APP_DB_USERNAME} \
        -p${APP_DB_PASSWORD} \
        -h${APP_DB_HOST} \
        ${APP_DB_DATABASE} \
        -e 'UPDATE `timezone` SET `default` = 1 WHERE `zone` = "'${DEFAULT_TIMEZONE}'";'
fi

if [ "${DEFAULT_ADMIN_CREATE}" == "true" ]
then
    res=$(
        mysql \
            -u${APP_DB_USERNAME} \
            -p${APP_DB_PASSWORD} \
            -h${APP_DB_HOST} \
            ${APP_DB_DATABASE} \
            -sse 'SELECT EXISTS(SELECT * FROM user WHERE email="'${DEFAULT_ADMIN_MAIL}'");'
    )

    if [ "${res}" = 0 ]
    then
        php artisan user:create \
            --email=${DEFAULT_ADMIN_MAIL} \
            --name=${DEFAULT_ADMIN_NAME} \
            --password=${DEFAULT_ADMIN_PASS} \
            --enabled \
            --admin
    fi
fi
echo "Starting cron"
cron

echo "Starting apache"
exec apache2-foreground
