#!/bin/bash

composer deploy-docker

php artisan timezone:geojson

crontab /etc/cron.d/cronjob
cron

php artisan serve --host=0.0.0.0 --port=80
