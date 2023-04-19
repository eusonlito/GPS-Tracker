<?php declare(strict_types=1);

namespace App\Domains\Trip\Model\Builder;

use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Trip extends BuilderAbstract
{
    /**
     * @param int $city_id
     * @param ?string $start_end = null
     *
     * @return self
     */
    public function byCityId(int $city_id, ?string $start_end = null): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('trip_id')->byCityId($city_id)->whenStartEnd($start_end));
    }

    /**
     * @param string $code
     *
     * @return self
     */
    public function byCode(string $code): self
    {
        return $this->where('code', $code);
    }

    /**
     * @param int $country_id
     * @param ?string $start_end = null
     *
     * @return self
     */
    public function byCountryId(int $country_id, ?string $start_end = null): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('trip_id')->byCountryId($country_id)->whenStartEnd($start_end));
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param float $radius
     *
     * @return self
     */
    public function byFence(float $latitude, float $longitude, float $radius): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('trip_id')->byFence($latitude, $longitude, $radius));
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtDateAfter(string $start_utc_at): self
    {
        return $this->whereDate('start_utc_at', '>=', $start_utc_at);
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtDateBefore(string $start_utc_at): self
    {
        return $this->whereDate('start_utc_at', '<=', $start_utc_at);
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtNext(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '>', $start_utc_at)->orderByStartUtcAtAsc();
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtPrevious(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '<', $start_utc_at)->orderByStartUtcAtDesc();
    }

    /**
     * @param int $state_id
     * @param ?string $start_end = null
     *
     * @return self
     */
    public function byStateId(int $state_id, ?string $start_end = null): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('trip_id')->byStateId($state_id)->whenStartEnd($start_end));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderByStartUtcAtDesc();
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function nearToStartUtcAtBefore(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '<=', $start_utc_at)->orderByStartUtcAtDesc();
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function nearToStartUtcAtNext(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '>=', $start_utc_at)->orderByStartUtcAtAsc();
    }

    /**
     * @return self
     */
    public function orderByStartAtAsc(): self
    {
        return $this->orderBy('start_at', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByStartAtDesc(): self
    {
        return $this->orderBy('start_at', 'DESC');
    }

    /**
     * @return self
     */
    public function orderByStartUtcAtAsc(): self
    {
        return $this->orderBy('start_utc_at', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByStartUtcAtDesc(): self
    {
        return $this->orderBy('start_utc_at', 'DESC');
    }

    /**
     * @return self
     */
    public function selectSimple(): self
    {
        return $this->selectOnly('id', 'name', 'start_at', 'start_utc_at', 'end_at', 'end_utc_at', 'time', 'distance', 'device_id', 'vehicle_id');
    }

    /**
     * @param ?int $city_id
     * @param ?int $state_id
     * @param ?int $country_id
     * @param ?string $start_end = null
     *
     * @return self
     */
    public function whenCityStateCountry(?int $city_id, ?int $state_id, ?int $country_id, ?string $start_end = null): self
    {
        return match (true) {
            boolval($city_id) => $this->byCityId($city_id, $start_end),
            boolval($state_id) => $this->byStateId($state_id, $start_end),
            boolval($country_id) => $this->byCountryId($country_id, $start_end),
            default => $this,
        };
    }

    /**
     * @param bool $fence
     * @param float $latitude
     * @param float $longitude
     * @param float $radius
     *
     * @return self
     */
    public function whenFence(bool $fence, float $latitude, float $longitude, float $radius): self
    {
        return $this->when(
            $fence && $latitude && $longitude && $radius,
            static fn ($q) => $q->byFence($latitude, $longitude, $radius)
        );
    }

    /**
     * @param ?bool $shared
     *
     * @return self
     */
    public function whenShared(?bool $shared): self
    {
        return $this->when(is_bool($shared), static fn ($q) => $q->whereShared($shared));
    }

    /**
     * @param ?string $before_start_utc_at
     * @param ?string $after_start_utc_at
     *
     * @return self
     */
    public function whenStartUtcAtDateBeforeAfter(?string $before_start_utc_at, ?string $after_start_utc_at): self
    {
        return $this->whenStartUtcAtDateBefore($before_start_utc_at)->whenStartUtcAtDateAfter($after_start_utc_at);
    }

    /**
     * @param ?string $start_utc_at
     *
     * @return self
     */
    public function whenStartUtcAtDateAfter(?string $start_utc_at): self
    {
        return $this->when($start_utc_at, static fn ($q) => $q->byStartUtcAtDateAfter($start_utc_at));
    }

    /**
     * @param ?string $start_utc_at
     *
     * @return self
     */
    public function whenStartUtcAtDateBefore(?string $start_utc_at): self
    {
        return $this->when($start_utc_at, static fn ($q) => $q->byStartUtcAtDateBefore($start_utc_at));
    }

    /**
     * @return self
     */
    public function whenStatsEmpty(): self
    {
        return $this->whereNull('stats');
    }

    /**
     * @param bool $shared = true
     *
     * @return self
     */
    public function whereShared(bool $shared = true): self
    {
        return $this->where('shared', $shared);
    }

    /**
     * @return self
     */
    public function withDevice(): self
    {
        return $this->with('device');
    }

    /**
     * @return self
     */
    public function withTimezone(): self
    {
        return $this->with('timezone');
    }

    /**
     * @return self
     */
    public function withVehicle(): self
    {
        return $this->with('vehicle');
    }
}
