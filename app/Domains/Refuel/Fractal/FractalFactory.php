<?php declare(strict_types=1);

namespace App\Domains\Refuel\Fractal;

use App\Domains\Core\Fractal\FractalAbstract;
use App\Domains\Refuel\Model\Refuel as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Refuel\Model\Refuel $row
     *
     * @return array
     */
    protected function json(Model $row): array
    {
        return [
            'id' => $row->id,
            'distance' => $row->distance,
            'distance_total' => $row->distance_total,
            'quantity' => $row->quantity,
            'quantity_before' => $row->quantity_before,
            'price' => $row->price,
            'total' => $row->total,
            'latitude' => $row->latitude,
            'longitude' => $row->longitude,
            'date_at' => $row->date_at,
            'user' => $this->from('User', 'related', $row->user),
            'vehicle' => $this->from('Vehicle', 'related', $row->vehicle),
        ];
    }

    /**
     * @param \App\Domains\Refuel\Model\Refuel $row
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
