#!/bin/bash

set -e

compose=(sudo docker compose -f docker/docker-compose.yml -f docker/docker-compose.compatibility.yml)

"${compose[@]}" stop
"${compose[@]}" up -d --no-build --pull never
