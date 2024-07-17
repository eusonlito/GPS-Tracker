#!/bin/bash

sudo rm -rf bootstrap/cache/*.php

if [ ! -f .env ]; then
    cp docker/.env.example .env
fi

if [ ! -f docker/docker-compose.yml ]; then
    cp docker/docker-compose.yml.example docker/docker-compose.yml
fi

sudo docker compose -f docker/docker-compose.yml stop

sudo docker compose -f docker/docker-compose.yml pull
sudo docker compose -f docker/docker-compose.yml build
