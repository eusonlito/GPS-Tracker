<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Index extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'vehicles' => $this->vehicles(),
            'vehicle' => $this->vehicle(),
            'devices' => $this->devices(),
            'trips' => $this->trips(),
            'trip' => $this->trip(),
            'trip_next_id' => $this->tripNextId(),
            'trip_previous_id' => $this->tripPreviousId(),
            'positions' => $this->positions(),
            'alarms' => $this->alarms(),
            'alarm_notifications' => $this->alarmNotifications(),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function vehicles(): Collection
    {
        return $this->cache[__FUNCTION__] ??= VehicleModel::query()
            ->byUserId($this->auth->id)
            ->list()
            ->get();
    }

    /**
     * @return ?\App\Domains\Vehicle\Model\Vehicle
     */
    protected function vehicle(): ?VehicleModel
    {
        return $this->cache[__FUNCTION__] ??= $this->vehicles()->firstWhere('id', $this->request->input('vehicle_id'))
            ?: $this->vehicles()->first();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function devices(): Collection
    {
        if ($this->vehicle() === null) {
            return collect();
        }

        return $this->cache[__FUNCTION__] ??= $this->vehicle()->devices()->list()->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function trips(): Collection
    {
        if ($this->vehicle() === null) {
            return collect();
        }

        return $this->cache[__FUNCTION__] ??= $this->vehicle()->trips()->list()->limit(50)->get();
    }

    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    protected function trip(): ?TripModel
    {
        return $this->cache[__FUNCTION__] ??= $this->trips()->firstWhere('id', $this->request->input('trip_id'))
            ?: $this->trips()->first();
    }

    /**
     * @return ?int
     */
    protected function tripNextId(): ?int
    {
        if ($this->trip() === null) {
            return null;
        }

        return $this->cache[__FUNCTION__] ??= $this->trips()
            ->reverse()
            ->firstWhere('start_utc_at', '>', $this->trip()->start_utc_at)
            ->id ?? null;
    }

    /**
     * @return ?int
     */
    protected function tripPreviousId(): ?int
    {
        if ($this->trip() === null) {
            return null;
        }

        return $this->cache[__FUNCTION__] ??= $this->trips()
            ->firstWhere('start_utc_at', '<', $this->trip()->start_utc_at)
            ->id ?? null;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function positions(): Collection
    {
        if ($this->trip() === null) {
            return collect();
        }

        return $this->cache[__FUNCTION__] ??= $this->trip()
            ->positions()
            ->withCity()
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function alarms(): Collection
    {
        if ($this->vehicle() === null) {
            return collect();
        }

        return $this->cache[__FUNCTION__] ??= AlarmModel::query()
            ->byVehicleId($this->vehicle()->id)
            ->enabled()
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function alarmNotifications(): Collection
    {
        if ($this->vehicle() === null) {
            return collect();
        }

        return $this->cache[__FUNCTION__] ??= AlarmNotificationModel::query()
            ->byVehicleId($this->vehicle()->id)
            ->withAlarm()
            ->withVehicle()
            ->withPosition()
            ->withTrip()
            ->list()
            ->get();
    }
}
