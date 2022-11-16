<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;

class UpdateDeviceMessageCreate extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): RedirectResponse
    {
        $this->row($id);

        $this->actionPost('updateDeviceMessageCreate');

        return redirect()->back();
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
