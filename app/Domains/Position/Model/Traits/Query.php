<?php declare(strict_types=1);

namespace App\Domains\Position\Model\Traits;

use App\Domains\Position\Model\Position as Model;
use App\Domains\Trip\Model\Builder\Trip as TripBuilder;

trait Query
{
    /**
     * @param \App\Domains\Trip\Model\Builder\Trip $tripBuilder
     *
     * @return array
     */
    public static function tripQueryBoundingBox(TripBuilder $tripBuilder): array
    {
        return (array)Model::query()
            ->selectOnlyBoundingBox()
            ->byTripQuery($tripBuilder)
            ->toBase()
            ->first();
    }
}
