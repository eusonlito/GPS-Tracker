<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\Device\Model\Device as DeviceModel;

class UpdateDevice extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateDevice')) {
            return $response;
        }

        $this->meta('title', $this->row->name);

        return $this->page('alarm.update-device', [
            'row' => $this->row,
            'devices' => $this->devices(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function devices(): Collection
    {
        return DeviceModel::query()
            ->list()
            ->withAlarmPivot($this->row->id)
            ->withTimeZone()
            ->get()
            ->sortByDesc('alarmPivot');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateDevice(): RedirectResponse
    {
        $this->action()->updateDevice();

        $this->sessionMessage('success', __('alarm-update-device.success'));

        return redirect()->route('alarm.update.device', $this->row->id);
    }
}
