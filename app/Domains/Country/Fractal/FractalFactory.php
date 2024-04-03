<?php declare(strict_types=1);

namespace App\Domains\Country\Fractal;

use App\Domains\Core\Fractal\FractalAbstract;
use App\Domains\Country\Model\Country as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Country\Model\Country $row
     *
     * @return array
     */
    protected function related(Model $row): array
    {
        return [
            'id' => $row->id,
            'code' => $row->code,
            'name' => $row->name,
        ];
    }
}
