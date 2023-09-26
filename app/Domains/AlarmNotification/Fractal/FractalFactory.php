<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Fractal;

use App\Domains\AlarmNotification\Model\AlarmNotification as Model;
use App\Domains\Core\Fractal\FractalAbstract;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\AlarmNotification\Model\AlarmNotification $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
            'type' => $row->type,
            'title' => $row->typeFormat()->title(),
            'message' => $row->typeFormat()->message(),
            'latitude' => $row->latitude,
            'longitude' => $row->longitude,
            'vehicle' => $this->fromIfLoaded('Vehicle', 'simple', $row, 'vehicle'),
            'alarm' => $this->fromIfLoaded('Alarm', 'simple', $row, 'alarm'),
        ];
    }
}
