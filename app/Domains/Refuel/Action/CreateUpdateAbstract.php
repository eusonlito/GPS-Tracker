<?php declare(strict_types=1);

namespace App\Domains\Refuel\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Refuel\Model\Refuel as Model;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @var \App\Domains\Device\Model\Device
     */
    protected DeviceModel $device;

    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Refuel\Model\Refuel
     */
    public function handle(): Model
    {
        $this->device();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function device(): void
    {
        $this->device = DeviceModel::query()
            ->findOrFail($this->data['device_id']);
    }
}
