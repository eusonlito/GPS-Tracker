<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as DeviceAlarmModel;
use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as DeviceAlarmNotificationModel;
use App\Domains\Trip\Model\Trip as Model;

class UpdateDeviceAlarmNotification extends UpdateAbstract
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

        return $this->page('trip.update-device-alarm-notification', [
            'positions' => $this->positions(),
            'notifications' => $this->notifications(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function positions(): Collection
    {
        return $this->row->positions()
            ->selectPointAsLatitudeLongitude()
            ->withCity()
            ->orderByDateUtcAtDesc()
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function notifications(): Collection
    {
        return DeviceAlarmNotificationModel::query()
            ->byTripId($this->row->id)
            ->withAlarm()
            ->list()
            ->get();
    }
}
