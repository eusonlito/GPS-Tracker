<?php declare(strict_types=1);

namespace App\Domains\City\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class City extends BuilderAbstract
{
    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return self
     */
    public function selectDistance(float $latitude, float $longitude): self
    {
        return $this->selectRaw(sprintf('*, ST_Distance_Sphere(`point`, ST_SRID(POINT(%f, %f), 4326)) `distance`', $latitude, $longitude));
    }

    /**
     * @param int $distance
     *
     * @return self
     */
    public function byDistanceMax(int $distance): self
    {
        return $this->where('distance', '<=', $distance);
    }

    /**
     * @return self
     */
    public function orderByDistance(): self
    {
        return $this->orderBy('distance', 'ASC');
    }

    /**
     * @return self
     */
    public function selectPointAsLatitudeLongitude(): self
    {
        return $this->selectRaw('
            `id`, `name`, `created_at`, `updated_at`, `state_id`,
            ROUND(ST_X(`point`), 5) AS `longitude`, ROUND(ST_Y(`point`), 5) AS `latitude`,
        ');
    }

    /**
     * @return self
     */
    public function withState(): self
    {
        return $this->with('state');
    }
}
