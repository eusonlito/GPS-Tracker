<?php declare(strict_types=1);

namespace App\Domains\Socket\Command;

class Server extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'socket:server {--port=} {--reset}';

    /**
     * @var string
     */
    protected $description = 'Create a Socket Server on {--port=} with {--reset} option.';

    /**
     * @return void
     */
    public function handle()
    {
        $this->middlewares();

        $this->checkOptions(['port']);
        $this->requestWithOptions();

        $this->factory()->action()->server();
    }
}
