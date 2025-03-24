<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class AlarmVehicle extends BuilderAbstract
{
    /**
     * @param int $alarm_id
     *
     * @return self
     */
    public function byAlarmId(int $alarm_id): self
    {
        return $this->where('alarm_id', $alarm_id);
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function byVehicleId(int $vehicle_id): self
    {
        return $this->where('vehicle_id', $vehicle_id);
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function byVehicleIdEnabled(int $vehicle_id): self
    {
        return $this->whereIn('vehicle_id', VehicleModel::query()->select('id')->byId($vehicle_id)->enabled());
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function byUserId(int $user_id): self
    {
        return $this->whereIn('vehicle_id', VehicleModel::query()->select('id')->byUserId($user_id));
    }
}
