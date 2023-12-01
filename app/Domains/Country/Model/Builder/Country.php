<?php declare(strict_types=1);

namespace App\Domains\Country\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\Position\Model\Position as PositionModel;

class Country extends BuilderAbstract
{
    /**
     * @param int $device_id
     * @param ?string $before_start_utc_at
     * @param ?string $after_start_utc_at
     * @param ?string $start_end
     *
     * @return self
     */
    public function byDeviceIdWhenTripStartUtcAtDateBetween(int $device_id, ?string $before_start_utc_at, ?string $after_start_utc_at, ?string $start_end): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('country_id')->byDeviceIdWhenTripStartUtcAtDateBetween($device_id, $before_start_utc_at, $after_start_utc_at, $start_end));
    }

    /**
     * @param int $vehicle_id
     * @param ?string $before_start_utc_at
     * @param ?string $after_start_utc_at
     * @param ?string $start_end
     *
     * @return self
     */
    public function byVehicleIdWhenTripStartUtcAtDateBetween(int $vehicle_id, ?string $before_start_utc_at, ?string $after_start_utc_at, ?string $start_end): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('country_id')->byVehicleIdWhenTripStartUtcAtDateBetween($vehicle_id, $before_start_utc_at, $after_start_utc_at, $start_end));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('name', 'ASC');
    }

    /**
     * @param ?int $user_id
     * @param ?int $vehicle_id
     * @param ?string $before_date_at
     * @param ?string $after_date_at
     *
     * @return self
     */
    public function whenRefuelUserIdVehicleIdDateAtBetween(?int $user_id, ?int $vehicle_id, ?string $before_date_at, ?string $after_date_at): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('country_id')->whenRefuelUserIdVehicleIdDateAtBetween($user_id, $vehicle_id, $before_date_at, $after_date_at));
    }

    /**
     * @param ?int $user_id
     * @param ?int $vehicle_id
     * @param ?string $before_date_at
     * @param ?string $after_date_at
     *
     * @return self
     */
    public function whenTripUserIdVehicleIdStartUtcAtBetween(?int $user_id, ?int $vehicle_id, ?string $before_start_utc_at, ?string $after_start_utc_at): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('country_id')->whenTripUserIdVehicleIdStartUtcAtBetween($user_id, $vehicle_id, $before_start_utc_at, $after_start_utc_at));
    }
}
