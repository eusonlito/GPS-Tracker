<?php

use App\Services\Locate\Arcgis;
use App\Services\Locate\Gisgraphy;
use App\Services\Locate\Nominatim;

return [
    'providers' => [Nominatim::class, Arcgis::class, Gisgraphy::class],
];
