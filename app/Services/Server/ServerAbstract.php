<?php declare(strict_types=1);

namespace App\Services\Server;

use Closure;
use Throwable;

abstract class ServerAbstract
{
    /**
     * @param \Closure $handler
     *
     * @return void
     */
    abstract public function accept(Closure $handler): void;

    /**
     * @param \Closure $handler
     *
     * @return void
     */
    abstract public function stop(): void;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param int $port
     *
     * @return self
     */
    public function __construct(protected int $port)
    {
    }

    /**
     * @return void
     */
    public function kill(): void
    {
        if ($this->isBusy() === false) {
            return;
        }

        shell_exec('fuser -k -SIGINT '.$this->port.'/tcp > /dev/null 2>&1');

        $count = 0;

        while (($count < 5) && $this->isBusy()) {
            sleep(++$count);
        }
    }

    /**
     * @return bool
     */
    public function isBusy(): bool
    {
        try {
            $fp = fsockopen('0.0.0.0', $this->port);
        } catch (Throwable $e) {
            return false;
        }

        fclose($fp);

        return true;
    }
}
