<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarmNotification\Job;

class Notify extends JobAbstract
{
    /**
     * @return void
     */
    public function handle()
    {
        $this->factory(row: $this->row())->action()->notify();
    }
}
