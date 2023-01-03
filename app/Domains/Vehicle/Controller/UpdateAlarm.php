<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\Collection\Alarm as AlarmCollection;

class UpdateAlarm extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateAlarm')) {
            return $response;
        }

        $this->meta('title', $this->row->name);

        return $this->page('vehicle.update-alarm', [
            'row' => $this->row,
            'alarms' => $this->alarms(),
        ]);
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function alarms(): AlarmCollection
    {
        return AlarmModel::query()
            ->list()
            ->withVehiclePivot($this->row->id)
            ->get()
            ->sortByDesc('vehiclePivot');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateAlarm(): RedirectResponse
    {
        $this->action()->updateAlarm();

        $this->sessionMessage('success', __('vehicle-update-alarm.success'));

        return redirect()->route('vehicle.update.alarm', $this->row->id);
    }
}
