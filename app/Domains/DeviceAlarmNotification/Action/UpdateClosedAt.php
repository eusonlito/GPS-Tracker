<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarmNotification\Action;

use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as Model;

class UpdateClosedAt extends ActionAbstract
{
    /**
     * @return \App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification
     */
    public function handle(): Model
    {
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        if ($this->row->closed_at) {
            return;
        }

        $this->row->closed_at = date('Y-m-d H:i:s');
        $this->row->save();
    }
}
