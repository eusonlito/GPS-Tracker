<?php declare(strict_types=1);

namespace App\Domains\Position\Schedule;

use App\Domains\Position\Command\UpdateCityEmpty as UpdateCityEmptyCommand;
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
