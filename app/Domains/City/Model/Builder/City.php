<?php declare(strict_types=1);

namespace App\Domains\City\Model\Builder;

use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class City extends BuilderAbstract
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
     * @param ?string $before_start_utc_at
     * @param ?string $after_start_utc_at
     * @param ?string $start_end
     *
     * @return self
     */
    public function byDeviceIdWhenTripStartUtcAtDateBetween(int $device_id, ?string $before_start_utc_at, ?string $after_start_utc_at, ?string $start_end): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('city_id')->byDeviceIdWhenTripStartUtcAtDateBetween($device_id, $before_start_utc_at, $after_start_utc_at, $start_end));
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
        return $this->whereIn('id', PositionModel::query()->selectOnly('city_id')->byVehicleIdWhenTripStartUtcAtDateBetween($vehicle_id, $before_start_utc_at, $after_start_utc_at, $start_end));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->selectOnly('id', 'name', 'state_id', 'country_id')->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByDistance(): self
    {
        return $this->orderBy('distance', 'ASC');
    }

    /**
     * @return self
     */
    public function selectRelated(): self
    {
        return $this->selectOnly('id', 'name', 'state_id', 'country_id')->withSimple('state');
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
            `id`, `name`, `created_at`, `updated_at`, `state_id`, `country_id`,
            ROUND(ST_Longitude(`point`), 5) AS `longitude`, ROUND(ST_Latitude(`point`), 5) AS `latitude`
        ');
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
        return $this->whereIn('id', PositionModel::query()->selectOnly('city_id')->whenRefuelUserIdVehicleIdDateAtBetween($user_id, $vehicle_id, $before_date_at, $after_date_at));
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
        return $this->whereIn('id', PositionModel::query()->selectOnly('city_id')->whenTripUserIdVehicleIdStartUtcAtBetween($user_id, $vehicle_id, $before_start_utc_at, $after_start_utc_at));
    }

    /**
     * @return self
     */
    public function withState(): self
    {
        return $this->with('state');
    }
}
