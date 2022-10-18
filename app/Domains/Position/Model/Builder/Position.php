<?php declare(strict_types=1);

namespace App\Domains\Position\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Position extends BuilderAbstract
{
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
}
