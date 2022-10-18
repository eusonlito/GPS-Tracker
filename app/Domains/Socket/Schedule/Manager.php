<?php declare(strict_types=1);

namespace App\Domains\Socket\Schedule;

use App\Domains\Shared\Schedule\ScheduleAbstract;
use App\Domains\Socket\Command\ServerAll as ServerAllCommand;

class Manager extends ScheduleAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->command(ServerAllCommand::class)->everyMinute();
    }
}
