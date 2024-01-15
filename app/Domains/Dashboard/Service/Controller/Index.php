<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\Collection\Alarm as AlarmCollection;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as AlarmNotificationCollection;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Trip\Model\Collection\Trip as TripCollection;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Server\Model\Server as ServerModel;

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
        $this->filters();
    }

    /**
     * @return void
     */
    protected function filters(): void
    {
        $this->filtersUserId();
        $this->filtersVehicleId();
        $this->filtersDeviceId();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'user' => $this->user(),
            'vehicle' => $this->vehicle(),
            'device' => $this->device(),

            'onboarding' => $this->onboarding(),
            'server' => $this->server(),

            'users' => $this->users(),
            'users_multiple' => $this->usersMultiple(),
            'user_empty' => $this->userEmpty(),
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle_empty' => $this->vehicleEmpty(),
            'devices' => $this->devices(),
            'devices_multiple' => $this->devicesMultiple(),
            'device_empty' => $this->deviceEmpty(),
            'trips' => $this->trips(),
            'trip' => $this->trip(),
            'trip_next_id' => $this->tripNextId(),
            'trip_previous_id' => $this->tripPreviousId(),
            'trip_alarm_notifications' => $this->tripAlarmNotifications(),
            'positions' => $this->positions(),
            'alarms' => $this->alarms(),
            'alarm_notifications' => $this->alarmNotifications(),
        ];
    }

    /**
     * @return bool
     */
    protected function onboarding(): bool
    {
        return ($this->vehicles()->count() === 0)
            || ($this->devices()->count() === 0)
            || ($this->trips()->count() === 0);
    }

    /**
     * @return ?\App\Domains\Server\Model\Server
     */
    protected function server(): ?ServerModel
    {
        if ($this->auth->adminMode() === false) {
            return null;
        }

        if ($this->onboarding() === false) {
            return null;
        }

        return $this->cache(
            fn () => ServerModel::query()
                ->enabled()
                ->first()
        );
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function trips(): TripCollection
    {
        if ($this->vehicle() === null) {
            return new TripCollection();
        }

        return $this->cache(
            fn () => TripModel::query()
                ->byVehicleId($this->vehicle()->id)
                ->whenDeviceId($this->device()?->id)
                ->listSimple()
                ->limit(50)
                ->get()
        );
    }

    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    protected function trip(): ?TripModel
    {
        return $this->cache(
            fn () => $this->trips()->firstWhere('id', $this->request->input('trip_id'))
                ?: $this->trips()->first()
        );
    }

    /**
     * @return ?int
     */
    protected function tripNextId(): ?int
    {
        if ($this->trip() === null) {
            return null;
        }

        return $this->cache(
            fn () => $this->trips()
                ->reverse()
                ->firstWhere('start_utc_at', '>', $this->trip()->start_utc_at)
                ?->id
        );
    }

    /**
     * @return ?int
     */
    protected function tripPreviousId(): ?int
    {
        if ($this->trip() === null) {
            return null;
        }

        return $this->cache(
            fn () => $this->trips()
                ->firstWhere('start_utc_at', '<', $this->trip()->start_utc_at)
                ?->id
        );
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function tripAlarmNotifications(): AlarmNotificationCollection
    {
        if ($this->trip() === null) {
            return new AlarmNotificationCollection();
        }

        return $this->cache(
            fn () => AlarmNotificationModel::query()
                ->byTripId($this->trip()->id)
                ->withAlarm()
                ->list()
                ->get()
        );
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        if ($this->trip() === null) {
            return new PositionCollection();
        }

        return $this->cache(
            fn () => $this->trip()
                ->positions()
                ->withCityState()
                ->list()
                ->get()
        );
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function alarms(): AlarmCollection
    {
        if ($this->vehicle() === null) {
            return new AlarmCollection();
        }

        return $this->cache(
            fn () => AlarmModel::query()
                ->byVehicleId($this->vehicle()->id)
                ->enabled()
                ->list()
                ->get()
        );
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function alarmNotifications(): AlarmNotificationCollection
    {
        if ($this->vehicle() === null) {
            return new AlarmNotificationCollection();
        }

        return $this->cache(
            fn () => AlarmNotificationModel::query()
                ->byVehicleId($this->vehicle()->id)
                ->whereClosedAt(false)
                ->withAlarm()
                ->withVehicle()
                ->withPosition()
                ->withTrip()
                ->list()
                ->get()
        );
    }
}
