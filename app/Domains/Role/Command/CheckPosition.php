<?php declare(strict_types=1);

namespace App\Domains\Alarm\Command;

class CheckPosition extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'alarm:check:position {--position_id=}';

    /**
     * @var string
     */
    protected $description = 'Check Alarm Using Position {--position_id=}';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->checkOptions(['position_id']);
        $this->requestWithOptions();

        $this->factory()->action()->checkPosition();

        $this->info('[END]');
    }
}
