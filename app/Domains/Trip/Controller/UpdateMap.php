<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;

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
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
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
    protected function alarms(): Collection
    {
        return AlarmModel::query()
            ->byVehicleId($this->row->vehicle->id)
            ->enabled()
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
            ->list()
            ->get();
    }
}
