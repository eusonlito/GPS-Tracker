<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as DeviceAlarmModel;

class UpdateDeviceAlarmDelete extends ActionAbstract
{
    /**
     * @var \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    protected DeviceAlarmModel $alarm;

    /**
     * @param \App\Domains\DeviceAlarm\Model\DeviceAlarm $alarm
     *
     * @return \App\Domains\Device\Model\Device
     */
    public function handle(DeviceAlarmModel $alarm): Model
    {
        $this->alarm = $alarm;

        $this->delete();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->factory('DeviceAlarm', $this->alarm)->action()->delete();
    }
}
