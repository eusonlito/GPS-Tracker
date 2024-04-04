<?php declare(strict_types=1);

namespace App\Domains\Profile\ControllerApi;

use Illuminate\Http\JsonResponse;

class Index extends ControllerApiAbstract
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->json($this->factory('User')->fractal('json', $this->auth));
    }
}
