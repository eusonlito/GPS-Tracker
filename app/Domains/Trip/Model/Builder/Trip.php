<?php declare(strict_types=1);

namespace App\Domains\Trip\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;
use App\Domains\Position\Model\Position as PositionModel;

class Trip extends BuilderAbstract
{
    /**
     * @param int $city_id
     *
     * @return self
     */
    public function byCityId(int $city_id): self
    {
        return $this->whereIn('id', PositionModel::select('trip_id')->byCityId($city_id));
    }

    /**
     * @param int $country_id
     *
     * @return self
     */
    public function byCountryId(int $country_id): self
    {
        return $this->whereIn('id', PositionModel::select('trip_id')->byCountryId($country_id));
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
     * @param int $days
     *
     * @return self
     */
    public function byLastDays(int $days): self
    {
        return $this->where('end_utc_at', '>=', date('Y-m-d H:i:s', strtotime('-'.$days.' days')));
    }

    /**
     * @param int $state_id
     *
     * @return self
     */
    public function byStateId(int $state_id): self
    {
        return $this->whereIn('id', PositionModel::select('trip_id')->byStateId($state_id));
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtNext(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '>', $start_utc_at)->orderBy('start_utc_at', 'ASC');
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtPrevious(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '<', $start_utc_at)->orderBy('start_utc_at', 'DESC');
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('start_utc_at', 'DESC');
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function nearToStartUtcAt(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '<=', $start_utc_at)->orderBy('start_utc_at', 'DESC');
    }

    /**
     * @param ?int $city_id
     * @param ?int $state_id
     * @param ?int $country_id
     *
     * @return self
     */
    public function whenCityStateCountry(?int $city_id, ?int $state_id, ?int $country_id): self
    {
        return match (true) {
            boolval($city_id) => $this->byCityId($city_id),
            boolval($state_id) => $this->byStateId($state_id),
            boolval($country_id) => $this->byCountryId($country_id),
            default => $this,
        };
    }

    /**
     * @param ?int $days
     *
     * @return self
     */
    public function whenLastDays(?int $days): self
    {
        return $this->when($days, static fn ($q) => $q->byLastDays($days));
    }

    /**
     * @return self
     */
    public function withTimezone(): self
    {
        return $this->with('timezone');
    }
}
