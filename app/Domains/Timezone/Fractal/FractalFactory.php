<?php declare(strict_types=1);

namespace App\Domains\Timezone\Fractal;

use App\Domains\Core\Fractal\FractalAbstract;
use App\Domains\Timezone\Model\Timezone as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Timezone\Model\Timezone $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return $row->only('id', 'zone', 'default');
    }
}
