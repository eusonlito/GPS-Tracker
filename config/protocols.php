<?php

use App\Services\Protocol\DebugHttp\Manager as DebugHttpManager;
use App\Services\Protocol\DebugSocket\Manager as DebugSocketManager;
use App\Services\Protocol\H02\Manager as H02Manager;
use App\Services\Protocol\OsmAnd\Manager as OsmAndManager;
use App\Services\Protocol\Queclink\Manager as QueclinkManager;

return [
    'debug-http' => DebugHttpManager::class,
    'debug-socket' => DebugSocketManager::class,
    'h02' => H02Manager::class,
    'osmand' => OsmAndManager::class,
    'queclink' => QueclinkManager::class,
];
