<?php declare(strict_types=1);

namespace App\Domains\Server\Command;

class StartPort extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'server:start:port {--port=} {--reset} {--debug}';

    /**
     * @var string
     */
    protected $description = 'Create a Server on {--port=} with {--reset} and {--debug} options.';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('START');

        $this->middlewares();

        $this->checkOptions(['port']);
        $this->requestWithOptions();

        $this->factory()->action()->startPort();

        $this->info('END');
    }
}
