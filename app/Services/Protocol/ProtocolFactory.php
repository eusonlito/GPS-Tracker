<?php declare(strict_types=1);

namespace App\Services\Protocol;

use App\Exceptions\UnexpectedValueException;

class ProtocolFactory
{
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
        return config('protocols')[$code] ?? null;
    }
}
