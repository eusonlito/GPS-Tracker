<?php declare(strict_types=1);

namespace App\Domains\Server\Command;

class StartPort extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'server:start:port {--port=} {--reset}';

    /**
     * @var string
     */
    protected $description = 'Create a Server on {--port=} with {--reset} option.';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('START');

        $this->middlewares();

        $this->checkOptions(['port']);
        $this->requestWithOptions();

        $this->factory()->action()->startPort();

        $this->info('END');
    }
}
