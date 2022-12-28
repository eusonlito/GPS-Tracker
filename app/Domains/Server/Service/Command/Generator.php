<?php declare(strict_types=1);

namespace App\Domains\Server\Service\Command;

class Generator
{
    /**
     * @param int $port
     * @param bool $reset = false
     * @param bool $debug = false
     *
     * @return string
     */
    public static function serverStartPort(int $port, bool $reset = false, bool $debug = false): string
    {
        return static::command('server:start:port', $port, $reset, $debug);
    }

    /**
     * @param string $command
     * @param int $port
     * @param bool $reset = false
     * @param bool $debug = false
     *
     * @return string
     */
    protected static function command(string $command, int $port, bool $reset, bool $debug): string
    {
        return implode(' ', array_filter([
            $command,
            static::port($port),
            static::reset($reset),
            static::debug($debug),
        ]));
    }

    /**
     * @param int $port
     *
     * @return string
     */
    protected static function port(int $port): string
    {
        return '--port='.$port;
    }

    /**
     * @param bool $reset
     *
     * @return ?string
     */
    protected static function reset(bool $reset): ?string
    {
        return $reset ? '--reset' : null;
    }

    /**
     * @param bool $debug
     *
     * @return ?string
     */
    protected static function debug(bool $debug): ?string
    {
        return $debug ? '--debug' : null;
    }
}
