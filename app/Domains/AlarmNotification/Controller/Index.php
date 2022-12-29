<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\AlarmNotification\Model\AlarmNotification as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response\\Illuminate\Http\JsonResponse
     */
    public function __invoke(): Response|JsonResponse
    {
        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        $this->meta('title', __('alarm-notification-index.meta-title'));

        return $this->page('alarm-notification.index', [
            'list' => $this->list(),
            'vehicles' => ($vehicles = $this->vehicles()),
            'vehicles_multiple' => ($vehicles->count() > 1),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function list(): Collection
    {
        return Model::query()
            ->byUserId($this->auth->id)
            ->withAlarm()
            ->withPosition()
            ->withTrip()
            ->withVehicle()
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function vehicles(): Collection
    {
        return VehicleModel::query()
            ->byUserId($this->auth->id)
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory()->fractal('simple', $this->responseJsonList()));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function responseJsonList(): Collection
    {
        return Model::query()
            ->byUserId($this->auth->id)
            ->whereClosedAt()
            ->whereSentAt()
            ->withAlarm()
            ->withVehicle()
            ->get();
    }
}
