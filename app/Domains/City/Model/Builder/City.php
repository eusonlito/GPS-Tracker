<?php declare(strict_types=1);

namespace App\Domains\City\Model\Builder;

use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\SharedApp\Model\Builder\BuilderAbstract;
use App\Domains\State\Model\State as StateModel;

class City extends BuilderAbstract
{
    /**
     * @param int $country_id
     *
     * @return self
     */
    public function byCountryId(int $country_id): self
    {
        return $this->whereIn('state_id', StateModel::query()->selectOnly('id')->byCountryId($country_id));
    }

    /**
     * @param int $state_id
     *
     * @return self
     */
    public function byStateId(int $state_id): self
    {
        return $this->where('state_id', $state_id);
    }

    /**
     * @param int $distance
     *
     * @return self
     */
    public function byDistanceMax(int $distance): self
    {
        return $this->where('distance', '<=', $distance);
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
        return $this->whereIn('id', PositionModel::query()->selectOnly('city_id')->byDeviceIdWhenTripStartUtcAtDateBeforeAfter($device_id, $trip_before_start_utc_at, $trip_after_start_utc_at, $trip_start_end));
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
        return $this->whereIn('id', PositionModel::query()->selectOnly('city_id')->byVehicleIdWhenTripStartUtcAtDateBeforeAfter($vehicle_id, $trip_before_start_utc_at, $trip_after_start_utc_at, $trip_start_end));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->selectOnly('id', 'name', 'state_id')->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByDistance(): self
    {
        return $this->orderBy('distance', 'ASC');
    }

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return self
     */
    public function selectDistance(float $latitude, float $longitude): self
    {
        return $this->selectRaw(sprintf('*, ST_Distance_Sphere(`point`, ST_SRID(POINT(%f, %f), 4326)) `distance`', $longitude, $latitude));
    }

    /**
     * @param string ...$columns
     *
     * @return self
     */
    public function selectOnly(string ...$columns): self
    {
        return $this->withoutGlobalScope('selectPointAsLatitudeLongitude')->select($columns);
    }

    /**
     * @return self
     */
    public function selectPointAsLatitudeLongitude(): self
    {
        return $this->selectRaw('
            `id`, `name`, `created_at`, `updated_at`, `state_id`,
            ROUND(ST_Longitude(`point`), 5) AS `longitude`, ROUND(ST_Latitude(`point`), 5) AS `latitude`
        ');
    }

    /**
     * @return self
     */
    public function withState(): self
    {
        return $this->with('state');
    }
}
