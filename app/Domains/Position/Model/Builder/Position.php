<?php declare(strict_types=1);

namespace App\Domains\Position\Model\Builder;

use App\Domains\City\Model\City as CityModel;
use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Position extends BuilderAbstract
{
    /**
     * @param int $city_id
     *
     * @return self
     */
    public function byCityId(int $city_id): self
    {
        return $this->where('city_id', $city_id);
    }

    /**
     * @param int $country_id
     *
     * @return self
     */
    public function byCountryId(int $country_id): self
    {
        return $this->whereIn('city_id', CityModel::select('id')->byCountryId($country_id));
    }

    /**
     * @param string $date_utc_at
     *
     * @return self
     */
    public function byDateUtcAt(string $date_utc_at): self
    {
        return $this->where('date_utc_at', $date_utc_at);
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
        return $this->where('date_utc_at', '>=', date('Y-m-d H:i:s', strtotime('-'.$days.' days')));
    }

    /**
     * @param int $state_id
     *
     * @return self
     */
    public function byStateId(int $state_id): self
    {
        return $this->whereIn('city_id', CityModel::select('id')->byStateId($state_id));
    }

    /**
     * @param int $trip_id
     *
     * @return self
     */
    public function byTripId(int $trip_id): self
    {
        return $this->where('trip_id', $trip_id);
    }

    /**
     * @param array $trip_ids
     *
     * @return self
     */
    public function byTripIds(array $trip_ids): self
    {
        return $this->whereIntegerInRaw('trip_id', $trip_ids);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderByDateUtcAtAsc();
    }

    /**
     * @param string $date_utc_at
     *
     * @return self
     */
    public function nearToDateUtcAt(string $date_utc_at): self
    {
        return $this->where('date_utc_at', '<=', $date_utc_at)->orderByDateUtcAtDesc();
    }

    /**
     * @param string $date_utc_at
     *
     * @return self
     */
    public function nextToDateUtcAt(string $date_utc_at): self
    {
        return $this->where('date_utc_at', '>', $date_utc_at);
    }

    /**
     * @return self
     */
    public function orderByDateUtcAtAsc(): self
    {
        return $this->orderBy('date_utc_at', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByDateUtcAtDesc(): self
    {
        return $this->orderBy('date_utc_at', 'DESC');
    }

    /**
     * @return self
     */
    public function selectPointAsLatitudeLongitude(): self
    {
        return $this->selectRaw('
            `id`, `speed`, `direction`, `signal`, `date_at`, `date_utc_at`, `created_at`, `updated_at`,
            ROUND(ST_X(`point`), 5) AS `longitude`, ROUND(ST_Y(`point`), 5) AS `latitude`,
            `city_id`, `device_id`, `timezone_id`, `trip_id`, `user_id`
        ');
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
     * @param ?string $start_end
     *
     * @return self
     */
    public function whenStartEnd(?string $start_end): self
    {
        return match ($start_end) {
            'start' => $this->whereStart(),
            'end' => $this->whereEnd(),
            default => $this,
        };
    }

    /**
     * @return self
     */
    public function whereEnd(): self
    {
        return $this->whereRaw('`date_utc_at` IN (SELECT MAX(`date_utc_at`) FROM `position` GROUP BY `trip_id`)');
    }

    /**
     * @return self
     */
    public function whereStart(): self
    {
        return $this->whereRaw('`date_utc_at` IN (SELECT MIN(`date_utc_at`) FROM `position` GROUP BY `trip_id`)');
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
    public function withCity(): self
    {
        return $this->with(['city' => static fn ($q) => $q->withState()]);
    }

    /**
     * @return self
     */
    public function withoutCity(): self
    {
        return $this->whereNull('city_id');
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
    public function withTrip(): self
    {
        return $this->with('trip');
    }
}
