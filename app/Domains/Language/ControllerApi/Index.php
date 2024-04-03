<?php declare(strict_types=1);

namespace App\Domains\Language\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\Language\Model\Language as Model;

class Index extends ControllerApiAbstract
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->json($this->factory()->fractal('json', Model::query()->list()->get()));
    }
}
