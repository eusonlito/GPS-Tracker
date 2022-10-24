<?php declare(strict_types=1);

namespace App\Domains\Position\Fractal;

use App\Domains\Shared\Fractal\FractalAbstract;
use App\Domains\Position\Model\Position as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Position\Model\Position $row
     *
     * @return array
     */
    protected function map(Model $row): array
    {
        return $row->only('id', 'date_at', 'latitude', 'longitude', 'speed', 'signal', 'created_at')
            + ['city' => $row->city->name, 'state' => $row->city->state->name];
    }
}
