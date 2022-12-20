<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model\Builder;

use App\Domains\Alarm\Model\AlarmVehicle as AlarmVehicleModel;
use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Alarm extends BuilderAbstract
{
    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function byVehicleId(int $vehicle_id): self
    {
        return $this->whereIn('id', AlarmVehicleModel::query()->selectOnly('alarm_id')->byVehicleId($vehicle_id));
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function byVehicleIdEnabled(int $vehicle_id): self
    {
        return $this->whereIn('id', AlarmVehicleModel::query()->selectOnly('alarm_id')->byVehicleIdEnabled($vehicle_id));
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function withVehiclePivot(int $vehicle_id): self
    {
        return $this->with(['vehiclePivot' => static fn ($q) => $q->byVehicleId($vehicle_id)]);
    }

    /**
     * @param string $serial
     *
     * @return self
     */
    public function byVehicleSerial(string $serial): self
    {
        return $this->whereIn('id', AlarmVehicleModel::query()->selectOnly('alarm_id')->byVehicleSerial($serial));
    }

    /**
     * @return self
     */
    public function withVehicles(): self
    {
        return $this->with('vehicles');
    }

    /**
     * @return self
     */
    public function withVehiclesCount(): self
    {
        return $this->withCount('vehicles');
    }

    /**
     * @return self
     */
    public function withNotificationsCount(): self
    {
        return $this->withCount('notifications');
    }

    /**
     * @return self
     */
    public function withNotificationsPendingCount(): self
    {
        return $this->withCount(['notifications as notifications_pending_count' => static fn ($q) => $q->whereClosedAt()]);
    }
}
