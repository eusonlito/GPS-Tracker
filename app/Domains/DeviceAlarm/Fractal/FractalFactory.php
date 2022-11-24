<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Fractal;

use App\Domains\Shared\Fractal\FractalAbstract;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\DeviceAlarm\Model\DeviceAlarm $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
            'type' => $row->type,
            'telegram' => $row->telegram,
            'enabled' => $row->enabled,
            'device' => $this->fromIfLoaded('Device', 'simple', $row, 'device'),
        ];
    }
}
