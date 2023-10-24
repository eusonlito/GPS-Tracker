<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Fractal;

use App\Domains\Core\Fractal\FractalAbstract;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\MaintenanceItem\Model\MaintenanceItem $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
        ];
    }
}
