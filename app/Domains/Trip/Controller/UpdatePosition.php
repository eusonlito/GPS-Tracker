<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\Collection\Alarm as AlarmCollection;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as AlarmNotificationCollection;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
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
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function responseJsonListPositions(): PositionCollection
    {
        return $this->row->positions()
            ->byIdNext((int)$this->request->input('id_from'))
            ->withCity()
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        return $this->row->positions()
            ->withCity()
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function alarms(): AlarmCollection
    {
        return AlarmModel::query()
            ->byVehicleId($this->row->vehicle->id)
            ->enabled()
            ->list()
            ->get();
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function notifications(): AlarmNotificationCollection
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
