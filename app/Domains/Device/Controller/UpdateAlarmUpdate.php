<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Alarm\Service\Type\Manager as AlarmTypeManager;

class UpdateAlarmUpdate extends ControllerAbstract
{
    /**
     * @param int $id
     * @param int $alarm_id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id, int $alarm_id): Response|RedirectResponse
    {
        $this->row($id);
        $this->alarm($alarm_id);

        if ($response = $this->actions()) {
            return $response;
        }

        $this->requestMergeWithRow(row: $this->alarm);

        $this->meta('title', $this->row->name);

        return $this->page('device.update-alarm-update', [
            'row' => $this->row,
            'alarm' => $this->alarm,
            'types' => AlarmTypeManager::new()->titles(),
            'type' => $this->alarm->type,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|false|null
     */
    protected function actions(): RedirectResponse|false|null
    {
        return $this->actionPost('updateAlarmUpdate')
            ?: $this->actionPost('updateAlarmDelete');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateAlarmUpdate(): RedirectResponse
    {
        $this->factory('Alarm', $this->alarm)->action()->update();

        $this->sessionMessage('success', __('device-update-alarm-update.update-success'));

        return redirect()->route('device.update.alarm', $this->row->id);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateAlarmDelete(): RedirectResponse
    {
        $this->factory('Alarm', $this->alarm)->action()->delete();

        $this->sessionMessage('success', __('device-update-alarm-update.delete-success'));

        return redirect()->route('device.update.alarm', $this->row->id);
    }
}
