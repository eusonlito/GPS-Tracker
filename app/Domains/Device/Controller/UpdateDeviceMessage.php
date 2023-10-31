<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\Response;
use App\Domains\Device\Service\Controller\UpdateDeviceMessage as ControllerService;

class UpdateDeviceMessage extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): Response
    {
        $this->row($id);

        $this->meta('title', __('device-update-device-message.meta-title', ['title' => $this->row->name]));

        return $this->page('device.update-device-message', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }
}
