<?php declare(strict_types=1);

namespace App\Services\Server;

use Closure;

abstract class ServerAbstract
{
    /**
     * @var \App\Services\Server\Pool
     */
    protected Pool $pool;

    /**
     * @var \App\Services\Server\Process
     */
    protected Process $process;

    /**
     * @var bool
     */
    protected bool $debug = false;

    /**
     * @param \Closure $handler
     *
     * @return void
     */
    abstract public function accept(Closure $handler): void;

    /**
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
        $this->pool = new Pool();
        $this->process = new Process();
    }

    /**
     * @param bool $debug
     *
     * @return self
     */
    public function debug(bool $debug): self
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * @return void
     */
    public function kill(): void
    {
        $this->process->kill($this->port);
    }

    /**
     * @return bool
     */
    public function isBusy(): bool
    {
        return $this->process->isBusy($this->port);
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->process->isLocked($this->port);
    }
}
