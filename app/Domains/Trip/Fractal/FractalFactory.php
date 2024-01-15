<?php declare(strict_types=1);

namespace App\Domains\Trip\Fractal;

use App\Domains\Core\Fractal\FractalAbstract;
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
            'id' => $row->id,
            'code' => $row->code,
            'name' => $row->name,
            'start_at' => $row->start_at,
            'start_utc_at' => $row->start_utc_at,
            'end_at' => $row->end_at,
            'end_utc_at' => $row->end_utc_at,
            'distance' => helper()->unit('distance', $row->distance),
            'distance_human' => helper()->unitHuman('distance', $row->distance),
            'time' => $row->time,
            'time_human' => helper()->timeHuman($row->time),
            'device' => $this->fromIfLoaded('Device', 'related', $row, 'device'),
            'vehicle' => $this->fromIfLoaded('Vehicle', 'related', $row, 'vehicle'),
            'user' => $this->fromIfLoaded('User', 'related', $row, 'user'),
            'positions' => $this->from('Position', 'related', $row->positions),
        ];
    }

    /**
     * @param \App\Domains\Trip\Model\Trip $row
     *
     * @return array
     */
    protected function live(Model $row): array
    {
        return [
            'code' => $row->code,
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

    /**
     * @param \App\Domains\Trip\Model\Trip $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return [
            'id' => $row->id,
            'code' => $row->code,
            'name' => $row->name,
            'start_at' => $row->start_at,
            'end_at' => $row->end_at,
            'distance' => helper()->unit('distance', $row->distance),
            'distance_human' => helper()->unitHuman('distance', $row->distance),
            'time' => $row->time,
            'time_human' => helper()->timeHuman($row->time),
            'shared' => $row->shared,
            'shared_public' => $row->shared_public,
        ];
    }
}
