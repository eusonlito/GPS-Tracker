#!/bin/bash

if ! grep -qE "^APP_KEY=[a-zA-Z0-9:]+\$" .env; then
    su -s /bin/bash -c 'php artisan key:generate' www-data
fi

su -s /bin/bash -c './composer deploy-docker > storage/logs/composer-deploy-docker.log 2>&1' www-data

cron

su -s /bin/bash -c 'php artisan serve --host=0.0.0.0 --port=80 > storage/logs/artisan-serve.log 2>&1' www-data
