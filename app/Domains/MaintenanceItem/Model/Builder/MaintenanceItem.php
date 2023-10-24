<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\Maintenance\Model\MaintenanceMaintenanceItem as MaintenanceMaintenanceItemModel;

class MaintenanceItem extends BuilderAbstract
{
    /**
     * @param string $name
     *
     * @return self
     */
    public function byName(string $name): self
    {
        return $this->where('name', $name);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByMaintenancesCount(): self
    {
        return $this->orderBy('maintenances_count', 'DESC');
    }

    /**
     * @return self
     */
    public function withMaintenancesCount(): self
    {
        return $this->withCount('maintenances');
    }

    /**
     * @return self
     */
    public function withStats(): self
    {
        return $this->selectRaw('COALESCE(`stats`.`amount_net_min`, 0) AS `amount_net_min`')
            ->selectRaw('COALESCE(`stats`.`amount_net_max`, 0) AS `amount_net_max`')
            ->selectRaw('COALESCE(`stats`.`amount_net_avg`, 0) AS `amount_net_avg`')
            ->selectRaw('COALESCE(`stats`.`quantity_sum`, 0) AS `quantity_sum`')
            ->selectRaw('COALESCE(`stats`.`total_sum`, 0) AS `total_sum`')
            ->leftJoinSub(
                MaintenanceMaintenanceItemModel::query()->selectMaintenanceItemStats(),
                'stats',
                static fn ($join) => $join->on('maintenance_item.id', '=', 'stats.maintenance_item_id')
            );
    }
}
