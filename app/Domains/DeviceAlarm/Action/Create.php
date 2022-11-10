<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;

class Create extends ActionAbstract
{
    /**
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    public function handle(): Model
    {
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataAlarm();
        $this->dataDeviceId();
    }

    /**
     * @return void
     */
    protected function dataAlarm(): void
    {
        $this->data['type'] = trim($this->data['type']);
    }

    /**
     * @return void
     */
    protected function dataDeviceId(): void
    {
        $this->data['device_id'] = DeviceModel::select('id')
            ->byId($this->data['device_id'])
            ->byUserId($this->auth->id)
            ->firstOrFail()
            ->id;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::create([
            'type' => $this->data['type'],
            'config' => $this->data['config'],
            'enabled' => $this->data['enabled'],
            'device_id' => $this->data['device_id'],
        ]);
    }
}
