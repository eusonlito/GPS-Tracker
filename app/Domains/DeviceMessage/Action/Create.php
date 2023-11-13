<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\DeviceMessage\Model\DeviceMessage as Model;

class Create extends ActionAbstract
{
    /**
     * @return \App\Domains\DeviceMessage\Model\DeviceMessage
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataMessage();
    }

    /**
     * @return void
     */
    protected function dataMessage(): void
    {
        $this->data['message'] = trim($this->data['message']);
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkDeviceId();
    }

    /**
     * @return void
     */
    protected function checkDeviceId(): void
    {
        if ($this->checkDeviceIdExists() === false) {
            $this->exceptionValidator(__('device-message-create.error.device-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkDeviceIdExists(): bool
    {
        return DeviceModel::query()
            ->byId($this->data['device_id'])
            ->byUserOrManager($this->auth)
            ->exists();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'message' => $this->data['message'],
            'device_id' => $this->data['device_id'],
        ]);
    }
}
