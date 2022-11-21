<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as DeviceAlarmModel;

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
        ]);
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function positions(): Collection
    {
        return $this->row->positions()
            ->selectPointAsLatitudeLongitude()
            ->withCity()
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function alarms(): Collection
    {
        return DeviceAlarmModel::query()
            ->byDeviceId($this->row->device->id)
            ->list()
            ->get();
    }
}
