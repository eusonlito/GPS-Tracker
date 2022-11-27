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
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataMessage();
        $this->dataDeviceId();
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
    protected function dataDeviceId(): void
    {
        $this->data['device_id'] = DeviceModel::query()
            ->selectOnly('id')
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
        $this->row = Model::query()->create([
            'message' => $this->data['message'],
            'device_id' => $this->data['device_id'],
        ]);
    }
}
