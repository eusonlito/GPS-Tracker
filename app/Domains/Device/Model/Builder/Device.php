<?php declare(strict_types=1);

namespace App\Domains\Device\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Device extends BuilderAbstract
{
    /**
     * @param string $serial
     *
     * @return self
     */
    public function bySerial(string $serial): self
    {
        return $this->where('serial', $serial);
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
        return $this->withCount(['alarmsNotifications as alarms_notifications_pending_count' => static fn ($q) => $q->whereClosedAt()]);
    }

    /**
     * @return self
     */
    public function withMessagesCount(): self
    {
        return $this->withCount('messages');
    }

    /**
     * @return self
     */
    public function withMessagesPendingCount(): self
    {
        return $this->withCount(['messages as messages_pending_count' => static fn ($q) => $q->whereResponseAt()]);
    }

    /**
     * @return self
     */
    public function withTimezone(): self
    {
        return $this->with('timezone');
    }
}
