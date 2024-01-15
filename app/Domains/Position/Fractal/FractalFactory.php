<?php declare(strict_types=1);

namespace App\Domains\Position\Fractal;

use App\Domains\Position\Model\Position as Model;
use App\Domains\Core\Fractal\FractalAbstract;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Position\Model\Position $row
     *
     * @return array
     */
    protected function map(Model $row): array
    {
        return [
            'id' => $row->id,
            'date_at' => $row->date_at,
            'latitude' => $row->latitude,
            'longitude' => $row->longitude,
            'direction' => $row->direction,
            'speed' => helper()->unit('speed', $row->speed),
            'speed_human' => helper()->unitHuman('speed', $row->speed),
            'city' => $row->city?->name,
            'state' => $row->city?->state?->name,
        ];
    }

    /**
     * @param \App\Domains\Position\Model\Position $row
     *
     * @return array
     */
    protected function related(Model $row): array
    {
        return [
            'id' => $row->id,
            'date_utc_at' => $row->date_utc_at,
            'latitude' => $row->latitude,
            'longitude' => $row->longitude,
        ];
    }
}
