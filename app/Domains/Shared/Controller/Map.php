<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Shared\Service\Controller\Map as ControllerService;

class Map extends ControllerAbstract
{
    /**
     * @param string $slug
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function __invoke(string $slug): Response|JsonResponse
    {
        $this->publicIsAvailable($slug);

        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        $this->meta('title', __('shared-map.meta-title'));

        return $this->page('shared.map', $this->data());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json($this->factory('Device')->fractal('map', $this->data()['devices']));
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request)->data();
    }
}
