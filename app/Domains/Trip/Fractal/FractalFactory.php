<?php declare(strict_types=1);

namespace App\Domains\Trip\Fractal;

use App\Domains\Shared\Fractal\FractalAbstract;
use App\Domains\Trip\Model\Trip as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Trip\Model\Trip $row
     *
     * @return array
     */
    protected function map(Model $row): array
    {
        return [
            'name' => $row->name,
            'start_at' => $row->start_at,
            'start_utc_at' => $row->start_utc_at,
            'end_at' => $row->end_at,
            'end_utc_at' => $row->end_utc_at,
            'distance' => helper()->unit('distance', $row->distance),
            'distance_human' => helper()->unitHuman('distance', $row->distance),
            'time' => $row->time,
            'positions' => $this->from('Position', 'map', $row->positions),
        ];
    }
}
