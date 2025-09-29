<?php declare(strict_types=1);

namespace App\Domains\Position\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\Position\ControllerApi\Service\Index as ControllerService;

class Index extends ControllerApiAbstract
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->json($this->factory()->fractal('api', $this->data()));
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
