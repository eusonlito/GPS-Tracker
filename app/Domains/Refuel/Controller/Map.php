<?php declare(strict_types=1);

namespace App\Domains\Refuel\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Refuel\Service\Controller\Map as ControllerService;

class Map extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function __invoke(): Response|JsonResponse
    {
        $this->meta('title', __('refuel-map.meta-title'));

        return $this->page('refuel.map', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
