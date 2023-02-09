#!/bin/bash

if [ "$1" != "" ]; then
    name="$1"
else
    name="app"
fi

container=$(sudo docker ps | grep "gpstracker-$name" | awk -F' ' '{print $1}')

sudo docker exec -it "$container" bash
