#!/bin/bash

if ! grep -qE "^APP_KEY=[a-zA-Z0-9:]+\$" .env; then
    php artisan key:generate
fi

LOG="storage/logs/deploy/$(date +"%Y/%m")/$(date +"%Y-%m-%d").log"

install -d $(dirname "$LOG")

COMPOSER_ALLOW_SUPERUSER=1 ./composer deploy-docker >> "$LOG" 2>&1

crontab /etc/cron.d/crontab
cron

while true; do
    LOG="storage/logs/serve/$(date +"%Y/%m")/$(date +"%Y-%m-%d").log"

    install -d $(dirname "$LOG")

    php artisan serve --host=0.0.0.0 --port=80 --no-reload >> "$LOG" 2>&1
done
