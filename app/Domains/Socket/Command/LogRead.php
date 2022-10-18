<?php declare(strict_types=1);

namespace App\Domains\Socket\Command;

class LogRead extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'socket:log:read {--file=} {--protocol=}';

    /**
     * @var string
     */
    protected $description = 'Read Socket Log from {--file=} using {--protocol=}';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->middlewares();

        $this->checkOptions(['file', 'protocol']);
        $this->requestWithOptions();

        $this->factory()->action()->logRead();

        $this->info('[END]');
    }
}
