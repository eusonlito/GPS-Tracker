<?php declare(strict_types=1);

namespace App\Domains\Trip\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\Trip\Service\ControllerApi\Index as ControllerService;

class Index extends ControllerApiAbstract
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->json($this->factory()->fractal('json', $this->data()));
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
