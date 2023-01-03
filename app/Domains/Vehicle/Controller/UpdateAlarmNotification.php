<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller;

use Illuminate\Http\Response;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as AlarmNotificationCollection;

class UpdateAlarmNotification extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): Response
    {
        $this->row($id);

        $this->meta('title', $this->row->name);

        return $this->page('vehicle.update-alarm-notification', [
            'row' => $this->row,
            'notifications' => $this->notifications(),
        ]);
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function notifications(): AlarmNotificationCollection
    {
        return $this->row->alarmsNotifications()
            ->withAlarm()
            ->withPosition()
            ->withTrip()
            ->list()
            ->get();
    }
}
