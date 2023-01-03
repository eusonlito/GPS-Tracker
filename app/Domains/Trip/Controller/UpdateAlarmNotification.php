<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\Response;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as AlarmNotificationCollection;
use App\Domains\Position\Model\Collection\Position as PositionCollection;

class UpdateAlarmNotification extends UpdateAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): Response
    {
        $this->load($id);

        $this->meta('title', $this->row->name);

        return $this->page('trip.update-alarm-notification', [
            'positions' => $this->positions(),
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
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function notifications(): AlarmNotificationCollection
    {
        return AlarmNotificationModel::query()
            ->byTripId($this->row->id)
            ->withAlarm()
            ->withVehicle()
            ->list()
            ->get();
    }
}
