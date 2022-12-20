<?php declare(strict_types=1);

namespace App\Domains\Country\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;
use App\Domains\State\Model\State as StateModel;

class Country extends BuilderAbstract
{
    /**
     * @param int $device_id
     * @param ?string $trip_before_start_utc_at
     * @param ?string $trip_after_start_utc_at
     * @param ?string $trip_start_end
     *
     * @return self
     */
    public function byDeviceIdWhenTripStartUtcAtDateBeforeAfter(int $device_id, ?string $trip_before_start_utc_at, ?string $trip_after_start_utc_at, ?string $trip_start_end): self
    {
        return $this->whereIn('id', StateModel::query()->selectOnly('country_id')->byDeviceIdWhenTripStartUtcAtDateBeforeAfter($device_id, $trip_before_start_utc_at, $trip_after_start_utc_at, $trip_start_end));
    }

    /**
     * @param int $vehicle_id
     * @param ?string $trip_before_start_utc_at
     * @param ?string $trip_after_start_utc_at
     * @param ?string $trip_start_end
     *
     * @return self
     */
    public function byVehicleIdWhenTripStartUtcAtDateBeforeAfter(int $vehicle_id, ?string $trip_before_start_utc_at, ?string $trip_after_start_utc_at, ?string $trip_start_end): self
    {
        return $this->whereIn('id', StateModel::query()->selectOnly('country_id')->byVehicleIdWhenTripStartUtcAtDateBeforeAfter($vehicle_id, $trip_before_start_utc_at, $trip_after_start_utc_at, $trip_start_end));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('name', 'ASC');
    }
}
