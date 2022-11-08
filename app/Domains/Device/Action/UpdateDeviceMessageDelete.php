<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;
use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;

class UpdateDeviceMessageDelete extends ActionAbstract
{
    /**
     * @var \App\Domains\DeviceMessage\Model\DeviceMessage
     */
    protected DeviceMessageModel $message;

    /**
     * @return \App\Domains\Device\Model\Device
     */
    public function handle(): Model
    {
        $this->message();
        $this->delete();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function message(): void
    {
        $this->message = DeviceMessageModel::byDeviceId($this->row->id)
            ->byId($this->data['device_message_id'])
            ->firstOrFail();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->factory('DeviceMessage', $this->message)->action()->delete();
    }
}
