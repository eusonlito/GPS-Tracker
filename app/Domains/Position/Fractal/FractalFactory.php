<?php declare(strict_types=1);

namespace App\Domains\Position\Fractal;

use App\Domains\Core\Fractal\FractalAbstract;
use App\Domains\Position\Model\Position as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Position\Model\Position $row
     *
     * @return array
     */
    protected function api(Model $row): array
    {
        return [
            'id' => $row->id,
            'latitude' => $row->latitude,
            'longitude' => $row->longitude,
            'speed' => helper()->unit('speed', $row->speed),
            'direction' => $row->direction,
            'signal' => $row->signal,
            'date_at' => $row->date_at,
            'date_utc_at' => $row->date_utc_at,
            'city' => $this->fromIfLoaded('City', 'related', $row, 'city'),
            'device' => $this->fromIfLoaded('Device', 'related', $row, 'device'),
            'timezone' => $this->fromIfLoaded('Timezone', 'related', $row, 'timezone'),
            'trip' => $this->fromIfLoaded('Trip', 'related', $row, 'trip'),
            'user' => $this->fromIfLoaded('User', 'related', $row, 'user'),
            'vehicle' => $this->fromIfLoaded('Vehicle', 'related', $row, 'vehicle'),
        ];
    }

    /**
     * @param \App\Domains\Position\Model\Position $row
     *
     * @return array
     */
    protected function json(Model $row): array
    {
        return [
            'id' => $row->id,
            'date_at' => $row->date_at,
            'date_utc_at' => $row->date_utc_at,
            'latitude' => $row->latitude,
            'longitude' => $row->longitude,
            'direction' => $row->direction,
            'speed' => helper()->unit('speed', $row->speed),
            'city' => $this->from('City', 'related', $row->city),
            'state' => $this->from('State', 'related', $row->city?->state),
            'country' => $this->from('Country', 'related', $row->city?->country),
        ];
    }

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
            'date_at' => $row->date_at,
            'date_utc_at' => $row->date_utc_at,
            'latitude' => $row->latitude,
            'longitude' => $row->longitude,
            'speed' => $row->speed,
            'direction' => $row->direction,
        ];
    }
}
