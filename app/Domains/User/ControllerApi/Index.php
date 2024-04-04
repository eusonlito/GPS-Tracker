<?php declare(strict_types=1);

namespace App\Domains\User\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\User\Model\User as Model;
use App\Domains\User\Model\Collection\User as Collection;

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
     * @return \App\Domains\User\Model\Collection\User
     */
    protected function data(): Collection
    {
        return Model::query()->list()->get();
    }
}
