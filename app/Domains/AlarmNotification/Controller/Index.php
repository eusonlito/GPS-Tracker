<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\AlarmNotification\Model\AlarmNotification as Model;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as Collection;
use App\Domains\AlarmNotification\Service\Controller\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function __invoke(): Response|JsonResponse
    {
        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        $this->meta('title', __('alarm-notification-index.meta-title'));

        return $this->page('alarm-notification.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory()->fractal('simple', $this->responseJsonList()));
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function responseJsonList(): Collection
    {
        return Model::query()
            ->byUserId($this->auth->id)
            ->whereClosedAt(false)
            ->whereSentAt()
            ->withAlarm()
            ->withVehicle()
            ->get();
    }
}
