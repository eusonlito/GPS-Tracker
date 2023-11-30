<?php declare(strict_types=1);

namespace App\Domains\Refuel\Action;

use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Refuel\Model\Refuel
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
        $this->dataUserId();
        $this->dataPositionId();
    }

    /**
     * @return void
     */
    protected function dataPositionId(): void
    {
        $this->data['position_id'] = PositionModel::query()
            ->byUserId($this->data['user_id'])
            ->nearToDateAt($this->data['date_at'])
            ->value('id');
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkVehicleId();
    }

    /**
     * @return void
     */
    protected function checkVehicleId(): void
    {
        if ($this->checkVehicleIdExists() === false) {
            $this->exceptionValidator(__('refuel-create.error.vehicle-exists'));
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
