<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\Alarm\Model\Alarm as AlarmModel;

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

        return $this->page('device.update-alarm', [
            'row' => $this->row,
            'alarms' => $this->alarms(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function alarms(): Collection
    {
        return AlarmModel::list()
            ->withDevicePivot($this->row->id)
            ->get()
            ->sortByDesc('devicePivot');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateAlarm(): RedirectResponse
    {
        $this->action()->updateAlarm();

        $this->sessionMessage('success', __('device-update-alarm.success'));

        return redirect()->route('device.update.alarm', $this->row->id);
    }
}
