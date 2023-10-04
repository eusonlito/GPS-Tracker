<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Device\Model\Device as Model;
use App\Domains\Device\Model\Collection\Device as Collection;

class Map extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function __invoke(): Response|JsonResponse
    {
        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        $this->meta('title', __('device-map.meta-title'));

        return $this->page('device.map', [
            'list' => $this->list(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory()->fractal('map', $this->list()));
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function list(): Collection
    {
        return Model::query()
            ->byUserId($this->auth->id)
            ->withVehicle()
            ->withWhereHasPositionLast()
            ->list()
            ->get();
    }
}
