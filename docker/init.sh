#!/bin/bash

su -s /bin/bash -c 'composer deploy-docker' www-data

su -s /bin/bash -c 'php artisan timezone:geojson' www-data

su -s /bin/bash -c 'php artisan server:start:all' www-data

cron

su -s /bin/bash -c 'php artisan serve --host=0.0.0.0 --port=80' www-data
