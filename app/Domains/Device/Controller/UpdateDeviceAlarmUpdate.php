<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\DeviceAlarm\Service\Type\Manager as DeviceAlarmTypeManager;

class UpdateDeviceAlarmUpdate extends ControllerAbstract
{
    /**
     * @param int $id
     * @param int $device_alarm_id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id, int $device_alarm_id): Response|RedirectResponse
    {
        $this->row($id);
        $this->alarm($device_alarm_id);

        if ($response = $this->actions()) {
            return $response;
        }

        $this->requestMergeWithRow(row: $this->alarm);

        $this->meta('title', $this->row->name);

        return $this->page('device.update-device-alarm-update', [
            'row' => $this->row,
            'types' => DeviceAlarmTypeManager::new()->titles(),
            'type' => $this->alarm->type,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|false|null
     */
    protected function actions(): RedirectResponse|false|null
    {
        return $this->actionPost('updateDeviceAlarmUpdate')
            ?: $this->actionPost('updateDeviceAlarmDelete');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateDeviceAlarmUpdate(): RedirectResponse
    {
        $this->factory('DeviceAlarm', $this->alarm)->action()->update();

        $this->sessionMessage('success', __('device-update-device-alarm-update.update-success'));

        return redirect()->route('device.update.device-alarm', $this->row->id);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateDeviceAlarmDelete(): RedirectResponse
    {
        $this->factory('DeviceAlarm', $this->alarm)->action()->delete();

        $this->sessionMessage('success', __('device-update-device-alarm-update.delete-success'));

        return redirect()->route('device.update.device-alarm', $this->row->id);
    }
}
