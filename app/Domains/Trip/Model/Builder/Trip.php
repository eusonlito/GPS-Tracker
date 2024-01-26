<?php declare(strict_types=1);

namespace App\Domains\Trip\Model\Builder;

use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

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
        return $this->whereIn('id', PositionModel::query()->selectOnly('trip_id')->byCityId($city_id)->whenTripStartEnd($start_end));
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
        return $this->whereIn('id', PositionModel::query()->selectOnly('trip_id')->byCountryId($country_id)->whenTripStartEnd($start_end));
    }

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
     * @param string $end_utc_at
     * @param int $minutes
     *
     * @return self
     */
    public function byEndUtcAtNearestMinutes(string $end_utc_at, int $minutes): self
    {
        return $this->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, `end_utc_at`, ?)) < ?', [$end_utc_at, $minutes])
            ->orderByEndUtcAtNearest($end_utc_at);
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
     * @param string $start_at
     *
     * @return self
     */
    public function byStartAtAfterEqualNear(string $start_at): self
    {
        return $this->where('start_at', '>=', $start_at)->orderByStartAtAsc();
    }

    /**
     * @param string $start_at
     *
     * @return self
     */
    public function byStartAtBeforeEqualNear(string $start_at): self
    {
        return $this->where('start_at', '<=', $start_at)->orderByStartAtDesc();
    }

    /**
     * @param string $start_at
     *
     * @return self
     */
    public function byStartAtDateAfterEqual(string $start_at): self
    {
        return $this->whereDate('start_at', '>=', $start_at);
    }

    /**
     * @param string $start_at
     *
     * @return self
     */
    public function byStartAtDateBeforeEqual(string $start_at): self
    {
        return $this->whereDate('start_at', '<=', $start_at);
    }

    /**
     * @param string $start_at
     *
     * @return self
     */
    public function byStartAtAfter(string $start_at): self
    {
        return $this->where('start_at', '>', $start_at)->orderByStartAtAsc();
    }

    /**
     * @param string $start_at
     *
     * @return self
     */
    public function byStartAtBefore(string $start_at): self
    {
        return $this->where('start_at', '<', $start_at)->orderByStartAtDesc();
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtAfterEqualNear(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '>=', $start_utc_at)->orderByStartUtcAtAsc();
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtBeforeEqualNear(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '<=', $start_utc_at)->orderByStartUtcAtDesc();
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtDateAfterEqual(string $start_utc_at): self
    {
        return $this->whereDate('start_utc_at', '>=', $start_utc_at);
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtDateBeforeEqual(string $start_utc_at): self
    {
        return $this->whereDate('start_utc_at', '<=', $start_utc_at);
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtAfter(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '>', $start_utc_at)->orderByStartUtcAtAsc();
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtBefore(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '<', $start_utc_at)->orderByStartUtcAtDesc();
    }

    /**
     * @param int $position_id
     *
     * @return self
     */
    public function byPositionIdFrom(int $position_id): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('trip_id')->byIdNext($position_id));
    }

    /**
     * @param int $state_id
     * @param ?string $start_end = null
     *
     * @return self
     */
    public function byStateId(int $state_id, ?string $start_end = null): self
    {
        return $this->whereIn('id', PositionModel::query()->selectOnly('trip_id')->byStateId($state_id)->whenTripStartEnd($start_end));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderByStartAtDesc();
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
     * @param string $end_utc_at
     *
     * @return self
     */
    public function orderByEndUtcAtNearest(string $end_utc_at): self
    {
        return $this->orderByRaw('ABS(TIMESTAMPDIFF(MINUTE, `end_utc_at`, ?)) ASC', [$end_utc_at]);
    }

    /**
     * @return self
     */
    public function selectSimple(): self
    {
        return $this->selectOnly(
            'id',
            'name',
            'code',
            'start_at',
            'start_utc_at',
            'end_at',
            'end_utc_at',
            'time',
            'distance',
            'shared',
            'shared_public',
            'device_id',
            'user_id',
            'vehicle_id'
        );
    }

    /**
     * @return self
     */
    public function listSimple(): self
    {
        return $this->selectSimple()->orderByStartAtDesc();
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
            fn ($q) => $q->byFence($latitude, $longitude, $radius)
        );
    }

    /**
     * @param ?bool $finished
     *
     * @return self
     */
    public function whenFinished(?bool $finished): self
    {
        return $this->when(is_bool($finished), fn ($q) => $q->whereFinished($finished));
    }

    /**
     * @param ?int $position_id
     *
     * @return self
     */
    public function whenPositionIdFrom(?int $position_id): self
    {
        return $this->when($position_id, fn ($q) => $q->byPositionIdFrom($position_id));
    }

    /**
     * @param ?bool $shared
     *
     * @return self
     */
    public function whenShared(?bool $shared): self
    {
        return $this->when(is_bool($shared), fn ($q) => $q->whereShared($shared));
    }

    /**
     * @param ?bool $shared_public
     *
     * @return self
     */
    public function whenSharedPublic(?bool $shared_public): self
    {
        return $this->when(is_bool($shared_public), fn ($q) => $q->whereSharedPublic($shared_public));
    }

    /**
     * @param ?string $before_start_at
     * @param ?string $after_start_at
     *
     * @return self
     */
    public function whenStartAtDateBetween(?string $before_start_at, ?string $after_start_at): self
    {
        return $this->whenStartAtDateAfter($before_start_at)->whenStartAtDateBefore($after_start_at);
    }

    /**
     * @param ?string $before_start_utc_at
     * @param ?string $after_start_utc_at
     *
     * @return self
     */
    public function whenStartUtcAtDateBetween(?string $before_start_utc_at, ?string $after_start_utc_at): self
    {
        return $this->whenStartUtcAtDateAfter($before_start_utc_at)->whenStartUtcAtDateBefore($after_start_utc_at);
    }

    /**
     * @param ?string $start_at
     *
     * @return self
     */
    public function whenStartAtDateAfter(?string $start_at): self
    {
        return $this->when($start_at, fn ($q) => $q->byStartAtDateAfterEqual($start_at));
    }

    /**
     * @param ?string $start_at
     *
     * @return self
     */
    public function whenStartAtDateBefore(?string $start_at): self
    {
        return $this->when($start_at, fn ($q) => $q->byStartAtDateBeforeEqual($start_at));
    }

    /**
     * @param ?string $start_utc_at
     *
     * @return self
     */
    public function whenStartUtcAtDateAfter(?string $start_utc_at): self
    {
        return $this->when($start_utc_at, fn ($q) => $q->byStartUtcAtDateAfterEqual($start_utc_at));
    }

    /**
     * @param ?string $start_utc_at
     *
     * @return self
     */
    public function whenStartUtcAtDateBefore(?string $start_utc_at): self
    {
        return $this->when($start_utc_at, fn ($q) => $q->byStartUtcAtDateBeforeEqual($start_utc_at));
    }

    /**
     * @return self
     */
    public function whenStatsEmpty(): self
    {
        return $this->whereNull('stats');
    }

    /**
     * @param ?int $user_id
     * @param ?int $vehicle_id
     * @param ?string $before_start_at
     * @param ?string $after_start_at
     *
     * @return self
     */
    public function whenUserIdVehicleIdStartAtBetween(?int $user_id, ?int $vehicle_id, ?string $before_start_at, ?string $after_start_at): self
    {
        return $this->whenUserId($user_id)
            ->whenVehicleId($vehicle_id)
            ->whenStartAtDateBetween($before_start_at, $after_start_at);
    }

    /**
     * @param ?int $user_id
     * @param ?int $vehicle_id
     * @param ?string $before_start_utc_at
     * @param ?string $after_start_utc_at
     *
     * @return self
     */
    public function whenUserIdVehicleIdStartUtcAtBetween(?int $user_id, ?int $vehicle_id, ?string $before_start_utc_at, ?string $after_start_utc_at): self
    {
        return $this->whenUserId($user_id)
            ->whenVehicleId($vehicle_id)
            ->whenStartUtcAtDateBetween($before_start_utc_at, $after_start_utc_at);
    }

    /**
     * @param bool $finished = true
     *
     * @return self
     */
    public function whereFinished(bool $finished = true): self
    {
        $time = strtotime('-'.app('configuration')->int('trip_wait_minutes').' minutes');
        $date = gmdate('Y-m-d H:i:s', $time);

        return $this->where('end_utc_at', $finished ? '<=' : '>=', $date);
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
     * @param bool $shared_public = true
     *
     * @return self
     */
    public function whereSharedPublic(bool $shared_public = true): self
    {
        return $this->whereShared()->where('shared_public', $shared_public);
    }

    /**
     * @return self
     */
    public function withDevice(): self
    {
        return $this->with('device');
    }

    /**
     * @param string $relation
     * @param bool $condition
     *
     * @return self
     */
    public function withSimpleWhen(string $relation, bool $condition): self
    {
        return $this->when($condition, fn ($q) => $q->withSimple($relation));
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
