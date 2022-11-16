<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarmNotification\Fractal;

use App\Domains\Shared\Fractal\FractalAbstract;
use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification $row
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
            'alarm' => $this->fromIfLoaded('DeviceAlarm', 'simple', $row, 'alarm'),
        ];
    }
}
