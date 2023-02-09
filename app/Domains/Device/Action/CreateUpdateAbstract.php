<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function data(): void;

    /**
     * @return void
     */
    abstract protected function check(): void;

    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Device\Model\Device
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
    protected function dataName(): void
    {
        $this->data['name'] = trim($this->data['name']);
    }

    /**
     * @return void
     */
    protected function dataMaker(): void
    {
        $this->data['maker'] = trim($this->data['maker']);
    }

    /**
     * @return void
     */
    protected function dataSerial(): void
    {
        $this->data['serial'] = trim($this->data['serial']);
    }

    /**
     * @return void
     */
    protected function dataPassword(): void
    {
        if (empty($this->data['password'])) {
            $this->data['password'] = $this->row->password ?? '';
        }
    }

    /**
     * @return void
     */
    protected function dataVehicleId(): void
    {
        if ($this->data['vehicle_id']) {
            $this->data['vehicle_id'] = VehicleModel::query()->selectOnly('id')->findOrFail($this->data['vehicle_id'])->id;
        } else {
            $this->data['vehicle_id'] = null;
        }
    }

    /**
     * @return void
     */
    protected function checkSerial(): void
    {
        if (Model::query()->byIdNot($this->row->id ?? 0)->bySerial($this->data['serial'])->count()) {
            $this->exceptionValidator(__('device-create.error.serial-exists'));
        }
    }
}
