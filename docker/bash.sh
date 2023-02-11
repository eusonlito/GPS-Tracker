#!/bin/bash

if [ "$1" != "" ]; then
    name="$1"
else
    name="app"
fi

container=$(sudo docker ps | grep "gpstracker-$name" | awk -F' ' '{print $1}')

if [ "$container" == "" ]; then
    echo ""
    echo "Container gpstracker-$name is not available yet"
    echo ""

    exit 1
fi

sudo docker exec -it "$container" bash
