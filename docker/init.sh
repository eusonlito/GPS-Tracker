#!/bin/bash

COMPOSER_ALLOW_SUPERUSER=1 composer deploy-docker

php artisan timezone:geojson
php artisan server:start:all

crontab /etc/cron.d/cronjob
cron

php artisan serve --host=0.0.0.0 --port=80
