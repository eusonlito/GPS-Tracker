<?php

use App\Services\Protocol\GT06\Manager as GT06Manager;
use App\Services\Protocol\H02\Manager as H02Manager;
use App\Services\Protocol\OsmAnd\Manager as OsmAndManager;

return [
    'gt06' => GT06Manager::class,
    'h02' => H02Manager::class,
    'osmand' => OsmAndManager::class,
];
