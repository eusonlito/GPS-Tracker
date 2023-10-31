<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

abstract class CreateUpdateAbstract extends ActionAbstract
{
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
    protected function data(): void
    {
        $this->dataName();
        $this->dataModel();
        $this->dataSerial();
        $this->dataPassword();
        $this->dataUserId();
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
    protected function dataModel(): void
    {
        $this->data['model'] = trim($this->data['model']);
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
    protected function check(): void
    {
        $this->checkCode();
        $this->checkSerial();
        $this->checkVehicleId();
    }

    /**
     * @return void
     */
    protected function checkCode(): void
    {
        if ($this->checkCodeExists()) {
            $this->exceptionValidator(__('device-create.error.code-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkCodeExists(): bool
    {
        return Model::query()
            ->byIdNot($this->row->id ?? 0)
            ->byCode($this->data['code'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function checkSerial(): void
    {
        if ($this->checkSerialExists()) {
            $this->exceptionValidator(__('device-create.error.serial-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkSerialExists(): bool
    {
        return Model::query()
            ->byIdNot($this->row->id ?? 0)
            ->bySerial($this->data['serial'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function checkVehicleId(): void
    {
        if ($this->data['vehicle_id'] && ($this->checkVehicleIdExists() === false)) {
            $this->exceptionValidator(__('device-create.error.vehicle-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkVehicleIdExists(): bool
    {
        return VehicleModel::query()
            ->byId($this->data['vehicle_id'])
            ->byUserId($this->data['user_id'])
            ->exists();
    }
}
