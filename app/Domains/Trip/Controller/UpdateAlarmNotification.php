<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\Response;
use App\Domains\Trip\Service\Controller\UpdateAlarmNotification as ControllerService;

class UpdateAlarmNotification extends UpdateAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id): Response
    {
        $this->load($id);

        $this->meta('title', __('trip-update-alarm-notification.meta-title', ['title' => $this->row->name]));

        return $this->page('trip.update-alarm-notification', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }
}
