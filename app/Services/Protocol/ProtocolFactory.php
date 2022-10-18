<?php declare(strict_types=1);

namespace App\Services\Protocol;

use App\Exceptions\UnexpectedValueException;

class ProtocolFactory
{
    /**
     * @param int $port
     *
     * @return \App\Services\Protocol\ProtocolAbstract
     */
    public static function fromPort(int $port): ProtocolAbstract
    {
        return static::new(static::classFromPort($port));
    }

    /**
     * @param string $code
     *
     * @return \App\Services\Protocol\ProtocolAbstract
     */
    public static function fromCode(string $code): ProtocolAbstract
    {
        return static::new(static::classFromCode($code));
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
     * @param int $port
     *
     * @return ?string
     */
    protected static function classFromPort(int $port): ?string
    {
        return config('protocols')[config('sockets')[$port] ?? null] ?? null;
    }

    /**
     * @param string $code
     *
     * @return ?string
     */
    protected static function classFromCode(string $code): ?string
    {
        return config('protocols')[$code] ?? null;
    }
}
