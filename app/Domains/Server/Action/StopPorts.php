<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Services\Server\Process;

class StopPorts extends ActionAbstract
{
    /**
     * @var \App\Services\Server\Process
     */
    protected Process $process;

    /**
     * @return void
     */
    public function handle(): void
    {
        if ($this->runningUnitTests()) {
            return;
        }

        $this->process();
        $this->iterate();
        $this->sleep();
    }

    /**
     * @return void
     */
    protected function process(): void
    {
        $this->process = new Process();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach ($this->process->list() as $process) {
            $this->kill($process->port);
        }
    }

    /**
     * @param int $port
     *
     * @return void
     */
    protected function kill(int $port): void
    {
        if ($this->isValidProcess($port)) {
            $this->killPort($port);
        }
    }

    /**
     * @param int $port
     *
     * @return void
     */
    protected function killPort(int $port): void
    {
        $this->process->kill($port);
    }

    /**
     * @param int $port
     *
     * @return bool
     */
    protected function isValidProcess(int $port): bool
    {
        return in_array($port, $this->data['ports']);
    }

    /**
     * @return void
     */
    protected function sleep(): void
    {
        sleep(1);
    }
}
