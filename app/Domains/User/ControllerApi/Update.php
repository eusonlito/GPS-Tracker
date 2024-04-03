<?php declare(strict_types=1);

namespace App\Domains\User\ControllerApi;

use Illuminate\Http\JsonResponse;

class Update extends ControllerApiAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $this->row($id);

        return $this->json($this->factory()->fractal('json', $this->action()->update()));
    }
}
