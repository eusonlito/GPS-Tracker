<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Model\Builder;

use App\Domains\Core\Model\Builder\BuilderAbstract as BuilderAbstractCore;
use App\Domains\User\Model\User as UserModel;

abstract class BuilderAbstract extends BuilderAbstractCore
{
    /**
     * @param int $device_id
     *
     * @return self
     */
    public function byDeviceId(int $device_id): self
    {
        return $this->where('device_id', $device_id);
    }

    /**
     * @param array $device_ids
     *
     * @return self
     */
    public function byDeviceIds(array $device_ids): self
    {
        return $this->whereIntegerInRaw('device_id', $device_ids);
    }

    /**
     * @param \App\Domains\User\Model\User $user
     *
     * @return self
     */
    public function byUserOrAdmin(UserModel $user): self
    {
        return $this->when(empty($user->admin), static fn ($q) => $q->byUserId($user->id));
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
     * @param array $vehicle_ids
     *
     * @return self
     */
    public function byVehicleIds(array $vehicle_ids): self
    {
        return $this->whereIntegerInRaw('vehicle_id', $vehicle_ids);
    }

    /**
     * @param ?int $device_id
     *
     * @return self
     */
    public function whenDeviceId(?int $device_id): self
    {
        return $this->when($device_id, static fn ($q) => $q->byDeviceId($device_id));
    }

    /**
     * @param ?int $user_id
     *
     * @return self
     */
    public function whenUserId(?int $user_id): self
    {
        return $this->when($user_id, static fn ($q) => $q->byUserId($user_id));
    }

    /**
     * @param ?int $vehicle_id
     *
     * @return self
     */
    public function whenVehicleId(?int $vehicle_id): self
    {
        return $this->when($vehicle_id, static fn ($q) => $q->byVehicleId($vehicle_id));
    }
}
