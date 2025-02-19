<?php

declare(strict_types=1);

namespace App\Domains\Role\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class RoleVehicle extends BuilderAbstract
{
    /**
     * @param int $Role_id
     *
     * @return self
     */
    public function byRoleId(int $Role_id): self
    {
        return $this->where('Role_id', $Role_id);
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
        return $this->whereIn('vehicle_id', VehicleModel::query()->selectOnly('id')->byId($vehicle_id)->enabled());
    }

    /**
     * @param string $serial
     *
     * @return self
     */
    public function byVehicleSerial(string $serial): self
    {
        return $this->whereIn('vehicle_id', VehicleModel::query()->selectOnly('id')->bySerial($serial));
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function byUserId(int $user_id): self
    {
        return $this->whereIn('vehicle_id', VehicleModel::query()->selectOnly('id')->byUserId($user_id));
    }
}
