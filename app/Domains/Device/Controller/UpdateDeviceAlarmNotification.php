<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Support\Collection;
use Illuminate\Http\Response;

class UpdateDeviceAlarmNotification extends ControllerAbstract
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

        return $this->page('device.update-device-alarm-notification', [
            'row' => $this->row,
            'notifications' => $this->notifications(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function notifications(): Collection
    {
        return $this->row->alarmsNotifications()
            ->withAlarm()
            ->withTrip()
            ->list()
            ->get();
    }
}
