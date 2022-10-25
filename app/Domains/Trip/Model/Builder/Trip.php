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
     * @param int $month
     *
     * @return self
     */
    public function byMonth(int $month): self
    {
        return $this->whereMonth('start_at', $month);
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
     * @param int $year
     *
     * @return self
     */
    public function byYear(int $year): self
    {
        return $this->whereYear('start_at', $year);
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
    public function nearToStartUtcAt(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '<=', $start_utc_at)->orderByStartUtcAtDesc();
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
    public function selectStartAtAsYear(): self
    {
        return $this->selectRaw('YEAR(`start_at`) `year`');
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
     * @param ?int $month
     *
     * @return self
     */
    public function whenMonth(?int $month): self
    {
        return $this->when($month, static fn ($q) => $q->byMonth($month));
    }

    /**
     * @param ?int $year
     *
     * @return self
     */
    public function whenYear(?int $year): self
    {
        return $this->when($year, static fn ($q) => $q->byYear($year));
    }

    /**
     * @return self
     */
    public function withTimezone(): self
    {
        return $this->with('timezone');
    }
}
