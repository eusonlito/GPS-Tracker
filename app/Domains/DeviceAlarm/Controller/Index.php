<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->json($this->factory()->fractal('simple', $this->list()));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function list(): Collection
    {
        return Model::query()->byUserId($this->auth->id)->enabled()->get();
    }
}
