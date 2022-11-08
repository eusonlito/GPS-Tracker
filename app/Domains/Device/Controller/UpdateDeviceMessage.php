<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UpdateDeviceMessage extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('updateDeviceMessageCreate')) {
            return $response;
        }

        $this->meta('title', $this->row->name);

        return $this->page('device.update-device-message', [
            'row' => $this->row,
            'messages' => $this->row->messages()->list()->get(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateDeviceMessageCreate(): RedirectResponse
    {
        $this->action()->updateDeviceMessageCreate();

        $this->sessionMessage('success', __('device-update-device-message.create-success'));

        return redirect()->route('device.update.device-message', $this->row->id);
    }
}
