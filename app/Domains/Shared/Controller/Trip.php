<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Trip\Model\Trip as TripModel;

class Trip extends ControllerAbstract
{
    /**
     * @var \App\Domains\Trip\Model\Trip
     */
    protected TripModel $trip;

    /**
     * @param string $code
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function __invoke(string $code): Response|JsonResponse
    {
        $this->trip($code);

        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        $this->meta('title', __('shared-trip.meta-title', ['title' => $this->trip->name]));

        return $this->page('shared.trip', [
            'trip' => $this->trip,
            'device' => $this->trip->device,
            'positions' => $this->positions(),
            'stats' => $this->trip->stats,
        ]);
    }

    /**
     * @param string $code
     *
     * @return void
     */
    protected function trip(string $code): void
    {
        $this->trip = TripModel::query()
            ->byCode($code)
            ->whereShared()
            ->firstOr(fn () => $this->exceptionNotFound(__('shared-trip.error.not-found')));

        $this->factory('User', $this->trip->user)->action()->set();
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        return $this->trip->positions()
            ->withCityState()
            ->list()
            ->get();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory('Trip')->fractal('live', $this->responseJsonList()));
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    protected function responseJsonList(): TripModel
    {
        return $this->trip->setRelation('positions', $this->responseJsonListPositions());
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function responseJsonListPositions(): PositionCollection
    {
        return $this->trip->positions()
            ->byIdNext((int)$this->request->input('id_from'))
            ->withCityState()
            ->list()
            ->get();
    }
}
