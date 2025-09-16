<?php declare(strict_types=1);

namespace App\Domains\Refuel\Schedule;

use App\Domains\Core\Schedule\ScheduleAbstract;
use App\Domains\Refuel\Command\UpdateCityEmpty as UpdateCityEmptyCommand;

class Manager extends ScheduleAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->command(UpdateCityEmptyCommand::class)->everyTenMinutes();
    }
}
