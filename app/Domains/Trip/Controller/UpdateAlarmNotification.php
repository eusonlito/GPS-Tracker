<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;

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
     * @return \Illuminate\Support\Collection
     */
    protected function positions(): Collection
    {
        return $this->row->positions()
            ->withCity()
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function notifications(): Collection
    {
        return AlarmNotificationModel::query()
            ->byTripId($this->row->id)
            ->withAlarm()
            ->withDevice()
            ->list()
            ->get();
    }
}
