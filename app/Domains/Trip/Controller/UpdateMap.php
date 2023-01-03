<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\Collection\Alarm as AlarmCollection;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as AlarmNotificationCollection;
use App\Domains\Position\Model\Collection\Position as PositionCollection;

class UpdateMap extends UpdateAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->load($id);

        $this->meta('title', $this->row->name);

        return $this->page('trip.update-map', [
            'positions' => $this->positions(),
            'alarms' => $this->alarms(),
            'notifications' => $this->notifications(),
        ]);
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        return $this->row->positions()
            ->withCity()
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function alarms(): AlarmCollection
    {
        return AlarmModel::query()
            ->byVehicleId($this->row->vehicle->id)
            ->enabled()
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function notifications(): AlarmNotificationCollection
    {
        return AlarmNotificationModel::query()
            ->byTripId($this->row->id)
            ->withAlarm()
            ->list()
            ->get();
    }
}
