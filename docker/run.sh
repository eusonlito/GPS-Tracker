#!/bin/bash

set -e

sudo docker compose -f docker/docker-compose.yml stop
sudo docker compose -f docker/docker-compose.yml up -d --no-build --pull never
