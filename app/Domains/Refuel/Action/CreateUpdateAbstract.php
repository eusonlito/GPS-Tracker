<?php declare(strict_types=1);

namespace App\Domains\Refuel\Action;

use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Refuel\Job\UpdateCity as UpdateCityJob;
use App\Domains\Refuel\Model\Refuel as Model;
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
        $this->job();
        $this->expense();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataUserId();
        $this->dataPoint();
        $this->dataPositionId();
        $this->dataLocation();
    }

    /**
     * @return void
     */
    protected function dataPoint(): void
    {
        $this->data['point'] = Model::pointFromLatitudeLongitude(
            $this->data['latitude'],
            $this->data['longitude'],
        );
    }

    /**
     * @return void
     */
    protected function dataPositionId(): void
    {
        $this->data['position_id'] = PositionModel::query()
            ->byUserId($this->data['user_id'])
            ->orderByDateAtNearest($this->data['date_at'])
            ->value('id');
    }

    /**
     * @return void
     */
    protected function dataLocation(): void
    {
        $this->data['city_id'] = $this->dataLocationDifferent() ? null : $this->row->city_id;
    }

    /**
     * @return bool
     */
    protected function dataLocationDifferent(): bool
    {
        return empty($this->row)
            || ($this->row->latitude !== $this->data['latitude'])
            || ($this->row->longitude !== $this->data['longitude']);
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

    /**
     * @return void
     */
    protected function job(): void
    {
        UpdateCityJob::dispatch($this->row->id);
    }

    /**
     * @return void
     */
    protected function expense(): void
    {
        $this->factory('Expense')->action([
            'name' => __('expense.sync.refuel'),
            'amount' => $this->row->total,
            'date_at' => $this->row->date_at,
            'distance' => $this->row->distance_total,
            'user_id' => $this->row->user_id,
            'vehicle_id' => $this->row->vehicle_id,
            'refuel_id' => $this->row->id,
        ])->upsertFromRefuel();
    }
}
