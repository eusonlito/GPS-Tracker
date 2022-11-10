<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;

class UpdateDeviceMessageCreate extends ActionAbstract
{
    /**
     * @var \App\Domains\DeviceMessage\Model\DeviceMessage
     */
    protected DeviceMessageModel $message;

    /**
     * @return \App\Domains\DeviceMessage\Model\DeviceMessage
     */
    public function handle(): DeviceMessageModel
    {
        $this->save();

        return $this->message;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->message = $this->factory('DeviceMessage')->action($this->saveData())->create();
    }

    /**
     * @return array
     */
    protected function saveData(): array
    {
        return ['device_id' => $this->row->id] + $this->request->input();
    }
}
