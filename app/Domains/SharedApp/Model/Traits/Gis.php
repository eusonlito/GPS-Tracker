<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Model\Traits;

use Illuminate\Database\Query\Expression;

trait Gis
{
    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return \Illuminate\Database\Query\Expression
     */
    public static function pointFromLatitudeLongitude(float $latitude, float $longitude): Expression
    {
        return static::DB()->raw(sprintf('ST_PointFromText("POINT(%f %f)", 4326)', $longitude, $latitude));
    }
}
