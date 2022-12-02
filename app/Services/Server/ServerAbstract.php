<?php declare(strict_types=1);

namespace App\Services\Server;

use Closure;

abstract class ServerAbstract
{
    /**
     * @var \App\Services\Server\Process
     */
    protected Process $process;

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
    }

    /**
     * @return void
     */
    public function kill(): void
    {
        $this->process()->kill($this->port);
    }

    /**
     * @return bool
     */
    public function isBusy(): bool
    {
        return $this->process()->isBusy($this->port);
    }

    /**
     * @return \App\Services\Server\Process
     */
    protected function process(): Process
    {
        return $this->process ??= new Process();
    }
}
