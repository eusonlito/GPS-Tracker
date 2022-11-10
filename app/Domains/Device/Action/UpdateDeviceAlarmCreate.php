<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\DeviceAlarm\Model\DeviceAlarm as DeviceAlarmModel;

class UpdateDeviceAlarmCreate extends ActionAbstract
{
    /**
     * @var \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    protected DeviceAlarmModel $alarm;

    /**
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    public function handle(): DeviceAlarmModel
    {
        $this->save();

        return $this->alarm;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->alarm = $this->factory('DeviceAlarm')->action($this->saveData())->create();
    }

    /**
     * @return array
     */
    protected function saveData(): array
    {
        return ['device_id' => $this->row->id] + $this->request->input();
    }
}
