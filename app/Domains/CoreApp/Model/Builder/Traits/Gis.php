<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Model\Builder\Traits;

trait Gis
{
    /**
     * @param float $latitude
     * @param float $longitude
     * @param int $meters
     *
     * @return self
     */
    public function inRadius(float $latitude, float $longitude, int $meters): self
    {
        return $this->whereRaw($this->inRadiusSql($latitude, $longitude, $meters));
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param int $meters
     *
     * @return string
     */
    protected function inRadiusSql(float $latitude, float $longitude, int $meters): string
    {
        return sprintf(
            'ST_Intersects(ST_Buffer(ST_SRID(POINT(%f, %f), 4326), %d), ST_SRID(`point`, 4326))',
            helper()->longitude($longitude),
            helper()->latitude($latitude),
            $meters,
        );
    }
}
