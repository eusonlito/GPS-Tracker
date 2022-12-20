<?php declare(strict_types=1);

namespace App\Domains\State\Model\Builder;

use App\Domains\City\Model\City as CityModel;
use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class State extends BuilderAbstract
{
    /**
     * @param int $country_id
     *
     * @return self
     */
    public function byCountryId(int $country_id): self
    {
        return $this->where('country_id', $country_id);
    }

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
        return $this->whereIn('id', CityModel::query()->selectOnly('state_id')->byDeviceIdWhenTripStartUtcAtDateBeforeAfter($device_id, $trip_before_start_utc_at, $trip_after_start_utc_at, $trip_start_end));
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
        return $this->whereIn('id', CityModel::query()->selectOnly('state_id')->byVehicleIdWhenTripStartUtcAtDateBeforeAfter($vehicle_id, $trip_before_start_utc_at, $trip_after_start_utc_at, $trip_start_end));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('name', 'ASC');
    }
}
