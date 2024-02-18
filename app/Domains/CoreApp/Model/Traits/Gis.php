<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Model\Traits;

use stdClass;
use Illuminate\Contracts\Database\Query\Expression;

trait Gis
{
    /**
     * @return string
     */
    public static function emptyGeoJSON(): string
    {
        return 'ST_GeomFromText("MULTIPOLYGON(((0 90,0 90,0 90,0 90)))")';
    }

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return \Illuminate\Contracts\Database\Query\Expression
     */
    public static function pointFromLatitudeLongitude(float $latitude, float $longitude): Expression
    {
        return static::db()->raw(sprintf(
            'ST_PointFromText("POINT(%f %f)", 4326, "axis-order=long-lat")',
            helper()->longitude($longitude),
            helper()->latitude($latitude)
        ));
    }

    /**
     * @param \stdClass $json
     * @param float $simplify = 0
     *
     * @return \Illuminate\Contracts\Database\Query\Expression
     */
    public static function geomFromGeoJSON(stdClass $json, float $simplify = 0): Expression
    {
        if ($json->type !== 'MultiPolygon') {
            $json->type = 'MultiPolygon';
            $json->coordinates = [$json->coordinates];
        }

        $sql = sprintf("ST_GeomFromGeoJSON('%s', 2, 0)", json_encode($json));

        if ($simplify) {
            $sql = 'ST_Simplify('.$sql.', '.$simplify.')';
        }

        return static::db()->raw($sql);
    }
}
