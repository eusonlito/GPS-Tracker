<?php declare(strict_types=1);

namespace App\Domains\Socket\Action;

use stdClass;
use App\Services\Protocol\ProtocolFactory;
use App\Services\Server\Process as ServerProcess;

class KillPorts extends ActionAbstract
{
    /**
     * @var array
     */
    protected array $config;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->config();
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function config(): void
    {
        $this->config = config('servers');
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach (ServerProcess::new()->list() as $process) {
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
        if ($this->isValidProcess($process) === false) {
            return;
        }

        ProtocolFactory::fromPort($process->port)->server($process->port)->kill();
    }

    /**
     * @param \stdClass $process
     *
     * @return bool
     */
    protected function isValidProcess(stdClass $process): bool
    {
        return (empty($this->config[$process->port]) === false)
            && in_array($process->port, $this->data['ports']);
    }
}
