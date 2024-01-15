<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Fractal;

use App\Domains\Core\Fractal\FractalAbstract;
use App\Domains\Position\Model\Position as PositionModel;
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
        return [
            'id' => $row->id,
            'name' => $row->name,
            'plate' => $row->plate,
        ];
    }

    /**
     * @param \App\Domains\Vehicle\Model\Vehicle $row
     *
     * @return array
     */
    protected function related(Model $row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
            'plate' => $row->plate,
        ];
    }

    /**
     * @param \App\Domains\Vehicle\Model\Vehicle $row
     *
     * @return array
     */
    protected function map(Model $row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
            'plate' => $row->plate,
            'position' => $this->mapPosition($row->positionLast),
        ];
    }

    /**
     * @param ?\App\Domains\Position\Model\Position $position
     *
     * @return ?array
     */
    protected function mapPosition(?PositionModel $position): ?array
    {
        if ($position === null) {
            return null;
        }

        return [
            'id' => $position->id,
            'date_at' => $position->date_at,
            'date_utc_at' => $position->date_utc_at,
            'latitude' => $position->latitude,
            'longitude' => $position->longitude,
            'direction' => $position->direction,
            'speed' => helper()->unit('speed', $position->speed),
            'speed_human' => helper()->unitHuman('speed', $position->speed),
            'city' => $position->city?->name,
            'state' => $position->city?->state->name,
        ];
    }
}
