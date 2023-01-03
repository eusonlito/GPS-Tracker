<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as AlarmNotificationCollection;

class UpdateAlarmNotification extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        $this->meta('title', $this->row->name);

        return $this->page('alarm.update-alarm-notification', [
            'row' => $this->row,
            'notifications' => $this->notifications(),
        ]);
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function notifications(): AlarmNotificationCollection
    {
        return $this->row->notifications()
            ->withVehicle()
            ->withPosition()
            ->withTrip()
            ->list()
            ->get();
    }
}
