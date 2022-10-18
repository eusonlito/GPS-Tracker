<?php declare(strict_types=1);

namespace App\Domains\Socket\Action;

use stdClass;
use App\Services\Socket\Process as SocketProcess;
use App\Services\Socket\Server as SocketServer;

class KillPorts extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach (SocketProcess::new()->list() as $process) {
            $this->kill($process);
        }
    }

    /**
     * @param \stdClass $process
     *
     * @return void
     */
    protected function kill(stdClass $process): void
    {
        if ($this->isValidProcess($process)) {
            SocketServer::new($process->port)->kill();
        }
    }

    /**
     * @param \stdClass $process
     *
     * @return bool
     */
    protected function isValidProcess(stdClass $process): bool
    {
        return in_array($process->port, $this->data['ports']);
    }
}
