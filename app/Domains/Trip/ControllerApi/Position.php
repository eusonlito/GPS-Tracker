<?php declare(strict_types=1);

namespace App\Domains\Trip\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\Trip\ControllerApi\Service\Position as ControllerService;

class Position extends ControllerApiAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $this->row($id);

        return $this->json($this->factory('Position')->fractal('json', $this->data()));
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }
}
