<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\Collection\Alarm as AlarmCollection;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as AlarmNotificationCollection;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Trip\Model\Collection\Trip as TripCollection;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Vehicle\Model\Collection\Vehicle as VehicleCollection;
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
        $this->filters();
    }

    /**
     * @return void
     */
    protected function filters(): void
    {
        $this->request->merge([
            'vehicle_id' => $this->auth->preference('vehicle_id', $this->request->input('vehicle_id')),
            'device_id' => $this->auth->preference('device_id', $this->request->input('device_id')),
        ]);
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
            'trip_alarm_notifications' => $this->tripAlarmNotifications(),
            'positions' => $this->positions(),
            'alarms' => $this->alarms(),
            'alarm_notifications' => $this->alarmNotifications(),
        ];
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function vehicles(): VehicleCollection
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
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function devices(): DeviceCollection
    {
        if ($this->vehicle() === null) {
            return new DeviceCollection();
        }

        return $this->cache[__FUNCTION__] ??= $this->vehicle()->devices()->list()->get();
    }

    /**
     * @return ?\App\Domains\Device\Model\Device
     */
    protected function device(): ?DeviceModel
    {
        return $this->cache[__FUNCTION__] ??= $this->devices()->firstWhere('id', $this->request->input('device_id'))
            ?: $this->devices()->first();
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function trips(): TripCollection
    {
        if ($this->vehicle() === null) {
            return new TripCollection();
        }

        return $this->cache[__FUNCTION__] ??= TripModel::query()
            ->selectSimple()
            ->byVehicleId($this->vehicle()->id)
            ->whenDeviceId($this->device()->id ?? null)
            ->list()
            ->limit(50)
            ->get();
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
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function tripAlarmNotifications(): AlarmNotificationCollection
    {
        if ($this->trip() === null) {
            return new AlarmNotificationCollection();
        }

        return $this->cache[__FUNCTION__] ??= AlarmNotificationModel::query()
            ->byTripId($this->trip()->id)
            ->withAlarm()
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        if ($this->trip() === null) {
            return new PositionCollection();
        }

        return $this->cache[__FUNCTION__] ??= $this->trip()
            ->positions()
            ->withCity()
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function alarms(): AlarmCollection
    {
        if ($this->vehicle() === null) {
            return new AlarmCollection();
        }

        return $this->cache[__FUNCTION__] ??= AlarmModel::query()
            ->byVehicleId($this->vehicle()->id)
            ->enabled()
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function alarmNotifications(): AlarmNotificationCollection
    {
        if ($this->vehicle() === null) {
            return new AlarmNotificationCollection();
        }

        return $this->cache[__FUNCTION__] ??= AlarmNotificationModel::query()
            ->byVehicleId($this->vehicle()->id)
            ->whereClosedAt(false)
            ->withAlarm()
            ->withVehicle()
            ->withPosition()
            ->withTrip()
            ->list()
            ->get();
    }
}
