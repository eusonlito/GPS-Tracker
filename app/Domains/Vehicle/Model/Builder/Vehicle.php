<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class Vehicle extends BuilderAbstract
{
    /**
     * @return self
     */
    public function listSimple(): self
    {
        return $this->select('id', 'name')->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function selectRelated(): self
    {
        return $this->selectOnly('id', 'name', 'user_id');
    }

    /**
     * @return self
     */
    public function selectSimple(): self
    {
        return $this->select('id', 'name', 'plate', 'enabled', 'timezone_id', 'user_id');
    }

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
    public function withDevicesCount(): self
    {
        return $this->withCount('devices');
    }

    /**
     * @return self
     */
    public function withTimezone(): self
    {
        return $this->with('timezone');
    }
}
