<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Model\Builder;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

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
        return $this->whereIn('device_id', DeviceModel::query()->selectOnly('id')->byUserId($user_id));
    }

    /**
     * @param bool $closed_at = false
     *
     * @return self
     */
    public function whereClosedAt(bool $closed_at = false): self
    {
        return $this->when(
            $closed_at,
            static fn ($q) => $q->whereNotNull('closed_at'),
            static fn ($q) => $q->whereNull('closed_at')
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
            static fn ($q) => $q->whereNotNull('sent_at'),
            static fn ($q) => $q->whereNull('sent_at')
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
    public function withDevice(): self
    {
        return $this->with('device');
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
}
