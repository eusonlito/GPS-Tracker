<?php declare(strict_types=1);

namespace App\Domains\Trip\Command;

class Import extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'trip:import {--user_id=} {--device_id=} {--vehicle_id=} {--timezone_id=} {--file=}';

    /**
     * @var string
     */
    protected $description = 'Import CSV Trip File using {--user_id=} {--device_id=} {--vehicle_id=} {--timezone_id=} {--file=}';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->checkOptions(['user_id', 'device_id', 'vehicle_id', 'file']);

        $this->requestWithOptions();
        $this->requestOptionAsFile('file');

        $this->actingAs(intval($this->option('user_id')));

        $this->info($this->factory()->action()->import()->toArray());

        $this->info('[END]');
    }
}
