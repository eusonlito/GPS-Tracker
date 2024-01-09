<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Services\Server\Process;

class Delete extends ActionAbstract
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
        $this->process();
        $this->kill();
        $this->delete();
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
    protected function kill(): void
    {
        if ($this->killIsRunning()) {
            $this->process->kill($this->row->port);
        }
    }

    /**
     * @return bool
     */
    protected function killIsRunning(): bool
    {
        return $this->process
            ->list()
            ->where('port', $this->row->port)
            ->isNotEmpty();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->row->delete();
    }
}
