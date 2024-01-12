<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Trip\Service\Controller\Map as ControllerService;

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

        $this->meta('title', __('trip-map.meta-title'));

        return $this->page('trip.map', $this->data());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->responseJsonData());
    }

    /**
     * @return array
     */
    protected function responseJsonData(): array
    {
        return $this->factory()->fractal('map', ControllerService::new($this->request, $this->auth)->json());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
