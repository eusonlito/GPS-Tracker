<?php declare(strict_types=1);

namespace App\Domains\Device\Fractal;

use App\Domains\Device\Model\Device as Model;
use App\Domains\Shared\Fractal\FractalAbstract;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Device\Model\Device $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return $row->only('id', 'name');
    }
}
