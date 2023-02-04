<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\JsonResponse;
use App\Domains\Server\Model\Server as Model;

class UpdateBoolean extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $this->row($id);

        return $this->json($this->fractal($this->action()->updateBoolean()));
    }

    /**
     * @param \App\Domains\Server\Model\Server $row
     *
     * @return array
     */
    protected function fractal(Model $row): array
    {
        return $this->factory()->fractal('simple', $row);
    }
}
