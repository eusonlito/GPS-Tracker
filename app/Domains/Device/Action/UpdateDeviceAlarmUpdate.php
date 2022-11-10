<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\DeviceAlarm\Model\DeviceAlarm as DeviceAlarmModel;

class UpdateDeviceAlarmUpdate extends ActionAbstract
{
    /**
     * @var \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    protected DeviceAlarmModel $alarm;

    /**
     * @param \App\Domains\DeviceAlarm\Model\DeviceAlarm $alarm
     *
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    public function handle(DeviceAlarmModel $alarm): DeviceAlarmModel
    {
        $this->alarm = $alarm;

        $this->save();

        return $this->alarm;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->alarm = $this->factory('DeviceAlarm', $this->alarm)->action($this->saveData())->update();
    }

    /**
     * @return array
     */
    protected function saveData(): array
    {
        return $this->request->input();
    }
}
