<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class AlarmNotification extends BuilderAbstract
{
    /**
     * @param int $alarm_id
     *
     * @return self
     */
    public function byAlarmId(int $alarm_id): self
    {
        return $this->where('alarm_id', $alarm_id);
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
     * @param int $user_id
     *
     * @return self
     */
    public function byUserId(int $user_id): self
    {
        return $this->whereIn('vehicle_id', VehicleModel::query()->selectOnly('id')->byUserId($user_id));
    }

    /**
     * @return self
     */
    public function selectPointAsLatitudeLongitude(): self
    {
        return $this->selectRaw('
            `id`, `name`, `type`, `config`, `closed_at`, `sent_at`, `created_at`, `updated_at`,
            `latitude`, `longitude`, `telegram`, `date_at`, `date_utc_at`,
            `alarm_id`, `position_id`, `trip_id`, `vehicle_id`
        ');
    }

    /**
     * @param bool $closed_at
     *
     * @return self
     */
    public function whereClosedAt(bool $closed_at): self
    {
        return $this->when(
            $closed_at,
            fn ($q) => $q->whereNotNull('closed_at'),
            fn ($q) => $q->whereNull('closed_at')
        );
    }

    /**
     * @param bool $sent_at = false
     *
     * @return self
     */
    public function whereSentAt(bool $sent_at = false): self
    {
        return $this->when(
            $sent_at,
            fn ($q) => $q->whereNotNull('sent_at'),
            fn ($q) => $q->whereNull('sent_at')
        );
    }

    /**
     * @return self
     */
    public function withAlarm(): self
    {
        return $this->with('alarm');
    }

    /**
     * @return self
     */
    public function withPosition(): self
    {
        return $this->with('position');
    }

    /**
     * @return self
     */
    public function withTrip(): self
    {
        return $this->with('trip');
    }

    /**
     * @return self
     */
    public function withVehicle(): self
    {
        return $this->with('vehicle');
    }
}
