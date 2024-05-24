#!/bin/bash

sudo rm -rf bootstrap/cache/*.php

cp --update=none docker/.env.example .env
cp --update=none docker/docker-compose.yml.example docker/docker-compose.yml

sudo docker compose -f docker/docker-compose.yml stop

sudo docker compose -f docker/docker-compose.yml pull
sudo docker compose -f docker/docker-compose.yml build
