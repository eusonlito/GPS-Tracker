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
    public function byUserOrManager(UserModel $user): self
    {
        return $this->when($user->managerMode() === false, fn ($q) => $q->byUserId($user->id));
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
     * @param ?int $id
     *
     * @return self
     */
    public function whenId(?int $id): self
    {
        return $this->when($id, fn ($q) => $q->byId($id));
    }

    /**
     * @param ?int $device_id
     *
     * @return self
     */
    public function whenDeviceId(?int $device_id): self
    {
        return $this->when($device_id, fn ($q) => $q->byDeviceId($device_id));
    }

    /**
     * @param ?int $user_id
     *
     * @return self
     */
    public function whenUserId(?int $user_id): self
    {
        return $this->when($user_id, fn ($q) => $q->byUserId($user_id));
    }

    /**
     * @param ?int $vehicle_id
     *
     * @return self
     */
    public function whenVehicleId(?int $vehicle_id): self
    {
        return $this->when($vehicle_id, fn ($q) => $q->byVehicleId($vehicle_id));
    }

    /**
     * @param string $relation
     *
     * @return self
     */
    public function withSimple(string $relation): self
    {
        return $this->with([$relation => fn ($q) => $q->selectRelated()]);
    }

    /**
     * @return self
     */
    public function withUser(): self
    {
        return $this->with('user');
    }
}
