#!/bin/bash

composer deploy-docker

php artisan timezone:geojson

php artisan server:start:all

php artisan serve --host=0.0.0.0 --port=80
