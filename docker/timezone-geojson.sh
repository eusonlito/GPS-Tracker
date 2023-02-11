#!/bin/bash

echo ""
echo "This command take about 5 minutes to finish..."
echo ""

sudo docker exec -it gpstracker-app bash -c "cd /app && su -s /bin/bash -c 'php -d memory_limit=-1 artisan timezone:geojson' www-data"
