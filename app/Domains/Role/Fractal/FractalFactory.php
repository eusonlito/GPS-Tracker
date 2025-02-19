<?php declare(strict_types=1);

namespace App\Domains\Alarm\Fractal;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Core\Fractal\FractalAbstract;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
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
            'vehicle' => $this->fromIfLoaded('Vehicle', 'simple', $row, 'vehicle'),
        ];
    }
}
