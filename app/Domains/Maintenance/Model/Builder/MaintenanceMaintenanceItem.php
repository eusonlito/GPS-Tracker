<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class MaintenanceMaintenanceItem extends BuilderAbstract
{
    /**
     * @param int $maintenance_id
     *
     * @return self
     */
    public function byMaintenanceId(int $maintenance_id): self
    {
        return $this->where('maintenance_id', $maintenance_id);
    }

    /**
     * @param int $maintenance_item_id
     *
     * @return self
     */
    public function byMaintenanceItemId(int $maintenance_item_id): self
    {
        return $this->where('maintenance_item_id', $maintenance_item_id);
    }

    /**
     * @param array $maintenance_item_ids
     *
     * @return self
     */
    public function byMaintenanceItemIds(array $maintenance_item_ids): self
    {
        return $this->whereIntegerInRaw('maintenance_item_id', $maintenance_item_ids);
    }

    /**
     * @param array $maintenance_item_ids
     *
     * @return self
     */
    public function byMaintenanceItemIdsNot(array $maintenance_item_ids): self
    {
        return $this->whereIntegerNotInRaw('maintenance_item_id', $maintenance_item_ids);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('id', 'ASC');
    }

    /**
     * @return self
     */
    public function selectMaintenanceItemStats(): self
    {
        return $this->selectOnly('maintenance_item_id')
            ->selectRaw('MIN(`amount_net`) `amount_net_min`')
            ->selectRaw('MAX(`amount_net`) `amount_net_max`')
            ->selectRaw('AVG(`amount_net`) `amount_net_avg`')
            ->selectRaw('SUM(`quantity`) `quantity_sum`')
            ->selectRaw('SUM(`total`) `total_sum`')
            ->groupBy('maintenance_item_id');
    }

    /**
     * @return self
     */
    public function withItem(): self
    {
        return $this->with('item');
    }

    /**
     * @return self
     */
    public function withMaintenance(): self
    {
        return $this->with('maintenance');
    }

    /**
     * @return self
     */
    public function withMaintenanceWithVehicle(): self
    {
        return $this->with(['maintenance' => fn ($q) => $q->withVehicle()]);
    }
}
