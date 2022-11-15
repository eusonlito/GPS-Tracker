<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Command;

class CheckPosition extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'device-alarm:check:position {--position_id=}';

    /**
     * @var string
     */
    protected $description = 'Check DeviceAlarm Using Position {--position_id=}';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->checkOptions(['position_id']);
        $this->requestWithOptions();

        $this->factory()->action()->checkPosition();

        $this->info('[END]');
    }
}
