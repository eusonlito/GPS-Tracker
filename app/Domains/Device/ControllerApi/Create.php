<?php declare(strict_types=1);

namespace App\Domains\Device\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\Device\Model\Device as Model;
use App\Domains\Device\Service\ControllerApi\Create as ControllerService;

class Create extends ControllerApiAbstract
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->json($this->factory()->fractal('json', $this->execute()));
    }

    /**
     * @return \App\Domains\Device\Model\Device
     */
    protected function execute(): Model
    {
        return $this->action(data: $this->data())->create();
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
