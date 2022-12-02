<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use Illuminate\Support\Collection;
use App\Domains\Server\Model\Server as Model;
use App\Services\Command\Artisan;

class StartAll extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->iterate();
        $this->sleep();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach ($this->list() as $port) {
            $this->command($port);
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function list(): Collection
    {
        return Model::query()
            ->enabled()
            ->pluck('port');
    }

    /**
     * @param int $port
     *
     * @return void
     */
    protected function command(int $port): void
    {
        Artisan::new($this->commandString($port))->exec();
    }

    /**
     * @param int $port
     *
     * @return string
     */
    protected function commandString(int $port): string
    {
        return 'server:start:port --port='.$port.($this->data['reset'] ? ' --reset' : '');
    }

    /**
     * @return void
     */
    protected function sleep(): void
    {
        sleep(1);
    }
}
