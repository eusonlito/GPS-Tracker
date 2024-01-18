<?php declare(strict_types=1);

namespace App\Services\Protocol;

use App\Exceptions\UnexpectedValueException;
use App\Services\Protocol\DebugHttp\Manager as DebugHttpManager;
use App\Services\Protocol\DebugSocket\Manager as DebugSocketManager;
use App\Services\Protocol\GPS103\Manager as GPS103Manager;
use App\Services\Protocol\GT06\Manager as GT06Manager;
use App\Services\Protocol\H02\Manager as H02Manager;
use App\Services\Protocol\OsmAnd\Manager as OsmAndManager;
use App\Services\Protocol\Queclink\Manager as QueclinkManager;
use App\Services\Protocol\Teltonika\Manager as TeltonikaManager;

class ProtocolFactory
{
    /**
     * @return array
     */
    public static function list(): array
    {
        return [
            'debug-http' => DebugHttpManager::class,
            'debug-socket' => DebugSocketManager::class,
            'gps103' => GPS103Manager::class,
            'gt06' => GT06Manager::class,
            'h02' => H02Manager::class,
            'osmand' => OsmAndManager::class,
            'queclink' => QueclinkManager::class,
            'teltonika' => TeltonikaManager::class,
        ];
    }

    /**
     * @param string $code
     *
     * @return \App\Services\Protocol\ProtocolAbstract
     */
    public static function get(string $code): ProtocolAbstract
    {
        return static::new(static::class($code));
    }

    /**
     * @param ?string $class
     *
     * @return \App\Services\Protocol\ProtocolAbstract
     */
    protected static function new(?string $class): ProtocolAbstract
    {
        if ($class === null) {
            throw new UnexpectedValueException(__('protocol.port-not-found'));
        }

        return new $class();
    }

    /**
     * @param string $code
     *
     * @return ?string
     */
    protected static function class(string $code): ?string
    {
        return static::list()[$code] ?? null;
    }
}
