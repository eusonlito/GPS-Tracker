<?php declare(strict_types=1);

namespace App\Domains\Server\Schedule;

use App\Domains\Core\Schedule\ScheduleAbstract;
use App\Domains\Server\Command\StartAll as StartAllCommand;

class Manager extends ScheduleAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->command(StartAllCommand::class)->everyMinute();
    }
}
