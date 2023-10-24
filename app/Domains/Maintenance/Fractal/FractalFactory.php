<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Fractal;

use App\Domains\Maintenance\Model\MaintenanceItem as MaintenanceItemModel;
use App\Domains\Core\Fractal\FractalAbstract;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\Maintenance\Model\MaintenanceItem $item
     *
     * @return array
     */
    protected function item(MaintenanceItemModel $item): array
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
        ];
    }
}
