<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

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
}
