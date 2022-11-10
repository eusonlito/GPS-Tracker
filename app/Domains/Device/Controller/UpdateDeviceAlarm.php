<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UpdateDeviceAlarm extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        $this->meta('title', $this->row->name);

        return $this->page('device.update-device-alarm', [
            'row' => $this->row,
            'alarms' => $this->row->alarms()->withNotificationsCount()->list()->get(),
        ]);
    }
}
