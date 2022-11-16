<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;

class UpdateDeviceMessageUpdate extends ControllerAbstract
{
    /**
     * @param int $id
     * @param int $device_message_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id, int $device_message_id): RedirectResponse
    {
        $this->row($id);
        $this->message($device_message_id);

        $this->actionPost('updateDeviceMessageDelete');

        return redirect()->back();
    }

    /**
     * @return void
     */
    protected function updateDeviceMessageDelete(): void
    {
        $this->factory('DeviceMessage', $this->message)->action()->delete();

        $this->sessionMessage('success', __('device-update-device-message-update.delete-success'));
    }
}
