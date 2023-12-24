<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\Collection\Alarm as AlarmCollection;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as AlarmNotificationCollection;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as Model;

class UpdateMap extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Trip\Model\Trip $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'row' => $this->row,
            'alarms' => $this->alarms(),
            'positions' => $this->positions(),
            'notifications' => $this->notifications(),
        ];
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        return $this->cache(
            fn () => PositionModel::query()
                ->byTripId($this->row->id)
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
        return $this->cache(
            fn () => AlarmModel::query()
                ->byVehicleId($this->row->vehicle->id)
                ->enabled()
                ->list()
                ->get()
        );
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function notifications(): AlarmNotificationCollection
    {
        return $this->cache(
            fn () => AlarmNotificationModel::query()
                ->byTripId($this->row->id)
                ->withAlarm()
                ->list()
                ->get()
        );
    }
}
