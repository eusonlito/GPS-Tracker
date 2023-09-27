<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Job;

class Notify extends JobAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->factory(row: $this->row())->action()->notify();
    }
}
