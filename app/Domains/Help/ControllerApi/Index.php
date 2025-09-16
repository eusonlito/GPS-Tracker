<?php declare(strict_types=1);

namespace App\Domains\Help\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\Help\ControllerApi\Service\Index as ControllerService;

class Index extends ControllerApiAbstract
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->json(ControllerService::new()->data());
    }
}
