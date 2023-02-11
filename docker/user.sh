#!/bin/bash

echo ""
echo "Adding an Admin User to GPS Tracker"
echo ""

while true; do
    read -p "Email: " email

    if [ "$email" != "" ]; then
        break;
    fi
done

while true; do
    read -p "Name: " name

    if [ "$name" != "" ]; then
        break;
    fi
done

while true; do
    read -p "Password: " password

    if [ "$password" != "" ]; then
        break;
    fi
done

echo ""

sudo docker exec -it gpstracker-app bash -c "cd /app && su -s /bin/bash -c 'php artisan user:create --email=$email --name=$name --password=$password --enabled --admin' www-data"
