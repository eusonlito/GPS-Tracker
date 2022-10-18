<?php declare(strict_types=1);

namespace App\Domains\Socket\Command;

class ServerAll extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'socket:server:all {--reset}';

    /**
     * @var string
     */
    protected $description = 'Create a Socket Server on All Ports with {--reset} option.';

    /**
     * @return void
     */
    public function handle()
    {
        $this->middlewares();

        $this->requestWithOptions();

        $this->factory()->action()->serverAll();
    }
}
