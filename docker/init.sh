#!/bin/bash

su -s /bin/bash -c 'composer deploy-docker' www-data

su -s /bin/bash -c 'php -d memory_limit=-1 artisan timezone:geojson' www-data

su -s /bin/bash -c 'php artisan server:start:all' www-data

cron

su -s /bin/bash -c 'php artisan serve --host=0.0.0.0 --port=80' www-data
