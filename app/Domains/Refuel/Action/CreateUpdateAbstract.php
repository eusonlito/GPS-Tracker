<?php declare(strict_types=1);

namespace App\Domains\Refuel\Action;

use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @var \App\Domains\Vehicle\Model\Vehicle
     */
    protected VehicleModel $vehicle;

    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Refuel\Model\Refuel
     */
    public function handle(): Model
    {
        $this->vehicle();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function vehicle(): void
    {
        $this->vehicle = VehicleModel::query()
            ->findOrFail($this->data['vehicle_id']);
    }
}
