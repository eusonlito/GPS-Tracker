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
    public function selectAmountNetAvgFromItem(): self
    {
        return $this->selectRaw('COALESCE(AVG(`amount_net`), 0)')->whereColumnMaintenanceItem();
    }

    /**
     * @return self
     */
    public function selectAmountNetMaxFromItem(): self
    {
        return $this->selectRaw('COALESCE(MAX(`amount_net`), 0)')->whereColumnMaintenanceItem();
    }

    /**
     * @return self
     */
    public function selectAmountNetMinFromItem(): self
    {
        return $this->selectRaw('COALESCE(MIN(`amount_net`), 0)')->whereColumnMaintenanceItem();
    }

    /**
     * @return self
     */
    public function whereColumnMaintenanceItem(): self
    {
        return $this->whereColumn('maintenance_item_id', 'maintenance_item.id');
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
        return $this->with(['maintenance' => static fn ($q) => $q->withVehicle()]);
    }
}
