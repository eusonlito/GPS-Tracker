<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\Alarm\Model\AlarmVehicle as AlarmVehicleModel;

class Alarm extends BuilderAbstract
{
    /**
     * @param string $time
     *
     * @return self
     */
    public function bySchedule(string $time): self
    {
        return $this->where(static function ($q) use ($time) {
            $q->where(fn ($q) => $q->whereScheduleIsEmpty())
                ->orWhere(fn ($q) => $q->byScheduleStart($time)->byScheduleEnd($time));
        });
    }

    /**
     * @param string $time
     *
     * @return self
     */
    public function byScheduleEnd(string $time): self
    {
        return $this->where('schedule_end', '>=', $time);
    }

    /**
     * @param string $time
     *
     * @return self
     */
    public function byScheduleStart(string $time): self
    {
        return $this->where('schedule_start', '<=', $time);
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function byType(string $type): self
    {
        return $this->where('type', $type);
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function byVehicleId(int $vehicle_id): self
    {
        return $this->whereIn('id', AlarmVehicleModel::query()->select('alarm_id')->byVehicleId($vehicle_id));
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function byVehicleIdEnabled(int $vehicle_id): self
    {
        return $this->whereIn('id', AlarmVehicleModel::query()->select('alarm_id')->byVehicleIdEnabled($vehicle_id));
    }

    /**
     * @return self
     */
    public function selectRelatedSimple(): self
    {
        return $this->select('id', 'name', 'type', 'enabled', 'user_id');
    }

    /**
     * @param bool $dashboard = true
     *
     * @return self
     */
    public function whereDashboard(bool $dashboard = true): self
    {
        return $this->where('dashboard', $dashboard);
    }

    /**
     * @return self
     */
    public function whereScheduleIsEmpty(): self
    {
        return $this->whereScheduleStartIsEmpty()->whereScheduleEndIsEmpty();
    }

    /**
     * @return self
     */
    public function whereScheduleEndIsEmpty(): self
    {
        return $this->whereRaw('TRIM(COALESCE(`schedule_end`, "")) = ""');
    }

    /**
     * @return self
     */
    public function whereScheduleStartIsEmpty(): self
    {
        return $this->whereRaw('TRIM(COALESCE(`schedule_start`, "")) = ""');
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function withVehiclePivot(int $vehicle_id): self
    {
        return $this->with(['vehiclePivot' => fn ($q) => $q->byVehicleId($vehicle_id)]);
    }

    /**
     * @return self
     */
    public function withVehicles(): self
    {
        return $this->with('vehicles');
    }

    /**
     * @return self
     */
    public function withVehiclesCount(): self
    {
        return $this->withCount('vehicles');
    }

    /**
     * @param int $vehicle_id
     *
     * @return self
     */
    public function withNotificationLastClosedAtByVehicleId(int $vehicle_id): self
    {
        return $this->with(['notificationLast' => fn ($q) => $q->select($q->addTable(['id', 'alarm_id', 'closed_at']))->byVehicleId($vehicle_id)]);
    }

    /**
     * @return self
     */
    public function withNotificationsCount(): self
    {
        return $this->withCount('notifications');
    }

    /**
     * @return self
     */
    public function withNotificationsPendingCount(): self
    {
        return $this->withCount([
            'notifications as notifications_pending_count' => fn ($q) => $q->whereClosedAt(false),
        ]);
    }
}
