#!/bin/bash

sudo rm -rf bootstrap/cache/*.php

cp -n docker/.env.example .env
cp -n docker/docker-compose.yml.example docker/docker-compose.yml

sudo docker-compose -f docker/docker-compose.yml build
