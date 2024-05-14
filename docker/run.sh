#!/bin/bash

sudo docker compose -f docker/docker-compose.yml stop
sudo docker compose -f docker/docker-compose.yml up -d
