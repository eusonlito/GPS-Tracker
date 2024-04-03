<?php declare(strict_types=1);

namespace App\Domains\State\Fractal;

use App\Domains\Core\Fractal\FractalAbstract;
use App\Domains\State\Model\State as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\State\Model\State $row
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
