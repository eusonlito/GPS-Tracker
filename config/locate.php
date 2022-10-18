<?php

use App\Services\Locate\Arcgis;
use App\Services\Locate\Nominatim;

return [
    'providers' => [Nominatim::class, Arcgis::class],
];
