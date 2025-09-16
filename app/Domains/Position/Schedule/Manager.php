<?php declare(strict_types=1);

namespace App\Domains\Position\Schedule;

use App\Domains\Core\Schedule\ScheduleAbstract;
use App\Domains\Position\Command\UpdateCityEmpty as UpdateCityEmptyCommand;

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
