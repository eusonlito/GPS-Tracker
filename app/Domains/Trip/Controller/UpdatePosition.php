<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\Trip\Model\Trip as Model;

class UpdatePosition extends UpdateAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|JsonResponse|RedirectResponse
    {
        $this->load($id);

        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        if ($response = $this->actions()) {
            return $response;
        }

        $this->meta('title', $this->row->name);

        return $this->page('trip.update-position', [
            'positions' => $this->positions(),
            'alarms' => $this->alarms(),
            'notifications' => $this->notifications(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory()->fractal('map', $this->responseJsonList()));
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    protected function responseJsonList(): Model
    {
        return $this->row->setRelation('positions', $this->responseJsonListPositions());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function responseJsonListPositions(): Collection
    {
        return $this->row->positions()
            ->byIdNext((int)$this->request->input('id_from'))
            ->withCity()
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function positions(): Collection
    {
        return $this->row->positions()
            ->withCity()
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function alarms(): Collection
    {
        return AlarmModel::query()
            ->byVehicleId($this->row->vehicle->id)
            ->enabled()
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function notifications(): Collection
    {
        return AlarmNotificationModel::query()
            ->byTripId($this->row->id)
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|false|null
     */
    protected function actions(): RedirectResponse|false|null
    {
        return $this->actionPost('updatePositionCreate')
            ?: $this->actionPost('updatePositionDelete');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updatePositionCreate(): RedirectResponse
    {
        $this->row = $this->action()->updatePositionCreate();

        $this->sessionMessage('success', __('trip-update-position.create-success'));

        return redirect()->route('trip.update.position', $this->row->id);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updatePositionDelete(): RedirectResponse
    {
        $this->action()->updatePositionDelete();

        $this->sessionMessage('success', __('trip-update-position.delete-success'));

        return redirect()->route('trip.update.position', $this->row->id);
    }
}
