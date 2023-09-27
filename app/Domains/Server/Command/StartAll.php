<?php declare(strict_types=1);

namespace App\Domains\Server\Command;

class StartAll extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'server:start:all {--reset} {--debug}';

    /**
     * @var string
     */
    protected $description = 'Start All Configured Servers with {--reset} and {--debug} options.';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('START');

        $this->middlewares();

        $this->requestWithOptions();

        $this->factory()->action()->startAll();

        $this->info('END');
    }
}
