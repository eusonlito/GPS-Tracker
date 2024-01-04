<?php declare(strict_types=1);

namespace App\Domains\Refuel\Schedule;

use App\Domains\Refuel\Command\UpdateCityEmpty as UpdateCityEmptyCommand;
use App\Domains\Core\Schedule\ScheduleAbstract;

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
