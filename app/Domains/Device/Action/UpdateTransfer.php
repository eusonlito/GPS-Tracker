<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class UpdateTransfer extends ActionAbstract
{
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
        $this->dataTrips();
    }

    /**
     * @return void
     */
    protected function dataTrips(): void
    {
        $this->data['trips'] = TripModel::query()
            ->byDeviceId($this->row->id)
            ->exists();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkTrips();
        $this->checkUserId();
        $this->checkVehicleId();
        $this->checkDeviceId();
    }

    /**
     * @return void
     */
    protected function checkTrips(): void
    {
        if ($this->data['trips'] === false) {
            return;
        }

        if (empty($this->data['vehicle_id']) || empty($this->data['device_id'])) {
            $this->exceptionValidator(__('device-update-transfer.error.trips-exists'));
        }
    }

    /**
     * @return void
     */
    protected function checkUserId(): void
    {
        if ($this->checkUserIdExists() === false) {
            $this->exceptionValidator(__('device-update-transfer.error.user-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkUserIdExists(): bool
    {
        return UserModel::query()
            ->byId($this->data['user_id'])
            ->byIdNot($this->row->user_id)
            ->exists();
    }

    /**
     * @return void
     */
    protected function checkVehicleId(): void
    {
        if ($this->data['trips'] && ($this->checkVehicleIdExists() === false)) {
            $this->exceptionValidator(__('device-update-transfer.error.vehicle-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkVehicleIdExists(): bool
    {
        return VehicleModel::query()
            ->byId($this->data['vehicle_id'])
            ->byUserId($this->row->user_id)
            ->exists();
    }

    /**
     * @return void
     */
    protected function checkDeviceId(): void
    {
        if ($this->data['trips'] && ($this->checkDeviceIdExists() === false)) {
            $this->exceptionValidator(__('device-update-transfer.error.device-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkDeviceIdExists(): bool
    {
        return Model::query()
            ->byId($this->data['device_id'])
            ->byUserId($this->row->user_id)
            ->byIdNot($this->row->id)
            ->exists();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveTrip();
        $this->savePosition();
        $this->saveRow();
    }

    /**
     * @return void
     */
    protected function saveTrip(): void
    {
        if ($this->data['trips'] === false) {
            return;
        }

        TripModel::query()
            ->byDeviceId($this->row->id)
            ->update($this->saveTripData());
    }

    /**
     * @return array
     */
    protected function saveTripData(): array
    {
        return [
            'device_id' => $this->data['device_id'],
            'vehicle_id' => $this->data['vehicle_id'],
        ];
    }

    /**
     * @return void
     */
    protected function savePosition(): void
    {
        if ($this->data['trips'] === false) {
            return;
        }

        PositionModel::query()
            ->byDeviceId($this->row->id)
            ->update($this->savePositionData());
    }

    /**
     * @return array
     */
    protected function savePositionData(): array
    {
        return [
            'device_id' => $this->data['device_id'],
            'vehicle_id' => $this->data['vehicle_id'],
        ];
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row->user_id = $this->data['user_id'];
        $this->row->vehicle_id = null;
        $this->row->save();
    }
}
