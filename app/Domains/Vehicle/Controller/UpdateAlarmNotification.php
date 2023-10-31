<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller;

use Illuminate\Http\Response;
use App\Domains\Vehicle\Service\Controller\UpdateAlarmNotification as ControllerService;

class UpdateAlarmNotification extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): Response
    {
        $this->row($id);

        $this->meta('title', __('vehicle-update-alarm-notification.meta-title', ['title' => $this->row->name]));

        return $this->page('vehicle.update-alarm-notification', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }
}
