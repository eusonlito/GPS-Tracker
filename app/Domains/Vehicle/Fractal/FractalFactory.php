<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Fractal;

use App\Domains\Shared\Fractal\FractalAbstract;
use App\Domains\Vehicle\Model\Vehicle as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Vehicle\Model\Vehicle $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return $row->only('id', 'name');
    }
}
