<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Fractal;

use App\Domains\Shared\Fractal\FractalAbstract;
use App\Domains\AlarmNotification\Model\AlarmNotification as Model;

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
            'device' => $this->fromIfLoaded('Device', 'simple', $row, 'device'),
            'alarm' => $this->fromIfLoaded('Alarm', 'simple', $row, 'alarm'),
        ];
    }
}
