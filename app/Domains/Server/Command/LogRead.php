<?php declare(strict_types=1);

namespace App\Domains\Server\Command;

class LogRead extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'server:log:read {--file=} {--protocol=}';

    /**
     * @var string
     */
    protected $description = 'Read Server Log from {--file=} using {--protocol=}';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->middlewares();

        $this->checkOptions(['file', 'protocol']);
        $this->requestWithOptions();

        $this->factory()->action()->logRead();

        $this->info('[END]');
    }
}
