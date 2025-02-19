<?php

declare(strict_types=1);

namespace App\Domains\Role\Controller;

use Illuminate\Http\JsonResponse;
use App\Domains\Role\Model\Role as Model;

class UpdateRoleBoolean extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $this->row($id);

        return $this->json($this->fractal($this->action()->updateRoleBoolean()));
    }

    /**
     * @param \App\Domains\Role\Model\Role $row
     *
     * @return array
     */
    protected function fractal(Model $row): array
    {
        return $this->factory()->fractal('simple', $row);
    }
}
