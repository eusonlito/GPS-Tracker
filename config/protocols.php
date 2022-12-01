<?php

use App\Services\Protocol\H02\Manager as H02Manager;
use App\Services\Protocol\OsmAnd\Manager as OsmAndManager;

return [
    'h02' => H02Manager::class,
    'osmand' => OsmAndManager::class,
];
