#!/bin/bash

set -e

mode="${1:-build}"
compose=(sudo docker compose -f docker/docker-compose.yml -f docker/docker-compose.compatibility.yml)

if [ ! -f .env ]; then
    cp docker/.env.example .env
fi

if [ ! -f docker/docker-compose.yml ]; then
    cp docker/docker-compose.yml.example docker/docker-compose.yml
fi

case "$mode" in
    build)
        sudo rm -rf bootstrap/cache/*.php
        "${compose[@]}" pull gpstracker-mysql gpstracker-redis
        "${compose[@]}" build gpstracker-app
        ;;
    pull)
        "${compose[@]}" pull
        ;;
    *)
        echo "Usage: $0 [build|pull]" >&2
        exit 1
        ;;
esac
