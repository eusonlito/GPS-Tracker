<?php declare(strict_types=1);

namespace App\Domains\Help\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\Help\Service\ControllerApi\Detail as ControllerService;

class Detail extends ControllerApiAbstract
{
    /**
     * @param string $name
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(string $name): JsonResponse
    {
        return $this->json(ControllerService::new($name)->data());
    }
}
