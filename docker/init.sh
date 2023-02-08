#!/bin/bash

if [ "$APP_KEY" == "base64:ORcH3F/Q65Fi+AL+sZj/lN9C0EEu4l3BXfNj3bBU/p4=" ]; then
    echo -e "\e[41m WARNING: YOU ARE USING THE DEFAULT APP_KEY VALUE. PLEASE UPDATE THIS KEY ON FILE .env BEFORE ADD YOUR FIRST APP \e[0m"
fi

composer deploy-docker

php artisan timezone:geojson

crontab /etc/cron.d/cronjob
cron

php artisan serve --host=0.0.0.0 --port=80
