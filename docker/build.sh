#!/bin/bash

sudo rm -rf bootstrap/cache/*.php

sudo docker-compose -f docker/docker-compose.yml build
