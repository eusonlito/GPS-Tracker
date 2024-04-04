<?php declare(strict_types=1);

namespace App\Domains\City\Fractal;

use App\Domains\Core\Fractal\FractalAbstract;
use App\Domains\City\Model\City as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\City\Model\City $row
     *
     * @return array
     */
    protected function related(Model $row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
        ];
    }
}
