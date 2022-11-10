<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UpdateDeviceAlarmCreate extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateDeviceAlarmCreate')) {
            return $response;
        }

        $this->meta('title', $this->row->name);

        return $this->page('device.update-device-alarm-create', [
            'row' => $this->row,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateDeviceAlarmCreate(): RedirectResponse
    {
        $this->action()->updateDeviceAlarmCreate();

        $this->sessionMessage('success', __('device-update-device-alarm.create-success'));

        return redirect()->route('device.update.device-alarm', $this->row->id);
    }
}
