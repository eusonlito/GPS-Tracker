<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as Model;
use App\Domains\Trip\Service\Controller\UpdatePosition as ControllerService;

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

        $this->meta('title', __('trip-update-position.meta-title', ['title' => $this->row->name]));

        return $this->page('trip.update-position', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory()->fractal('live', $this->responseJsonList()));
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
        return PositionModel::query()
            ->byTripId($this->row->id)
            ->byIdNext((int)$this->request->input('id_from'))
            ->withCityState()
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
