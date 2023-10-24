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
        return $this->addSelect([
            'amount_net_min' => MaintenanceMaintenanceItemModel::query()->selectAmountNetMinFromItem(),
            'amount_net_max' => MaintenanceMaintenanceItemModel::query()->selectAmountNetMaxFromItem(),
            'amount_net_avg' => MaintenanceMaintenanceItemModel::query()->selectAmountNetAvgFromItem(),
        ]);
    }
}
