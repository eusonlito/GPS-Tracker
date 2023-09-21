<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Services\Server\Process;

class StopAll extends ActionAbstract
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
            $this->process->kill($process->port);
        }
    }

    /**
     * @return void
     */
    protected function sleep(): void
    {
        sleep(1);
    }
}
