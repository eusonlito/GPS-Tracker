<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UpdateDeviceMessageCreate extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): RedirectResponse
    {
        $this->row($id);

        $this->actionPost('updateDeviceMessageCreate');

        return redirect()->route('device.update.device-message', $this->row->id);
    }

    /**
     * @return void
     */
    protected function updateDeviceMessageCreate(): void
    {
        $this->action()->updateDeviceMessageCreate();

        $this->sessionMessage('success', __('device-update-device-message.create-success'));
    }
}
