<?php declare(strict_types=1);

namespace App\Domains\Trip\Model\Traits;

use App\Domains\Trip\Model\Trip as Model;

trait Query
{
    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    public function next(): ?Model
    {
        return self::query()
            ->selectSimple()
            ->byVehicleId($this->vehicle->id)
            ->byStartUtcAtNext($this->start_utc_at)
            ->first();
    }

    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    public function previous(): ?Model
    {
        return self::query()
            ->selectSimple()
            ->byVehicleId($this->vehicle->id)
            ->byStartUtcAtPrevious($this->start_utc_at)
            ->first();
    }
}
