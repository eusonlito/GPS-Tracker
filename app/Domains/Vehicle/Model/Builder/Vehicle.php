<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Vehicle extends BuilderAbstract
{
    /**
     * @param int $alarm_id
     *
     * @return self
     */
    public function withAlarmPivot(int $alarm_id): self
    {
        return $this->with(['alarmPivot' => static fn ($q) => $q->byAlarmId($alarm_id)]);
    }

    /**
     * @return self
     */
    public function withAlarmsCount(): self
    {
        return $this->withCount('alarms');
    }

    /**
     * @return self
     */
    public function withAlarmsNotificationsCount(): self
    {
        return $this->withCount('alarmsNotifications as alarms_notifications_count');
    }

    /**
     * @return self
     */
    public function withAlarmsNotificationsPendingCount(): self
    {
        return $this->withCount([
            'alarmsNotifications as alarms_notifications_pending_count' => static fn ($q) => $q->whereClosedAt(false),
        ]);
    }

    /**
     * @return self
     */
    public function withDevices(): self
    {
        return $this->with('devices');
    }

    /**
     * @return self
     */
    public function withTimezone(): self
    {
        return $this->with('timezone');
    }
}
