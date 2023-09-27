<?php declare(strict_types=1);

namespace App\Domains\Server\Command;

class StopAll extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'server:stop:all';

    /**
     * @var string
     */
    protected $description = 'Stop All Running Servers.';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('START');

        $this->middlewares();

        $this->factory()->action()->stopAll();

        $this->info('END');
    }
}
