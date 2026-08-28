#!/bin/bash

set -e

mode="${1:-build}"

if [ ! -f .env ]; then
    cp docker/.env.example .env
fi

if [ ! -f docker/docker-compose.yml ]; then
    cp docker/docker-compose.yml.example docker/docker-compose.yml
fi

case "$mode" in
    build)
        sudo rm -rf bootstrap/cache/*.php
        sudo docker compose -f docker/docker-compose.yml pull gpstracker-mysql gpstracker-redis
        sudo docker compose -f docker/docker-compose.yml build gpstracker-app
        ;;
    pull)
        sudo docker compose -f docker/docker-compose.yml pull
        ;;
    *)
        echo "Usage: $0 [build|pull]" >&2
        exit 1
        ;;
esac
