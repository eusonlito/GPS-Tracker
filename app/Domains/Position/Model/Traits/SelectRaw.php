<?php declare(strict_types=1);

namespace App\Domains\Position\Model\Traits;

use App\Domains\Trip\Model\Builder\Trip as TripBuilder;

trait SelectRaw
{
    /**
     * @param \App\Domains\Trip\Model\Builder\Trip $tripBuilder
     * @param array $bounding_box = []
     *
     * @return array
     */
    public static function heatmap(TripBuilder $tripBuilder, array $bounding_box = []): array
    {
        $bounding_box = static::heatmapBoundingBox($bounding_box ?: static::tripQueryBoundingBox($tripBuilder));

        if (empty($bounding_box)) {
            return [];
        }

        static::db()->unprepared('
            SET @boundingBox = ST_SRID(ST_MakeEnvelope(
                Point('.$bounding_box['longitude_min'].', '.$bounding_box['latitude_min'].'),
                Point('.$bounding_box['longitude_max'].', '.$bounding_box['latitude_max'].')
            ), 4326);

            SET @distance = ST_Distance_Sphere(
                Point('.$bounding_box['longitude_min'].', '.$bounding_box['latitude_min'].'),
                Point('.$bounding_box['longitude_max'].', '.$bounding_box['latitude_min'].')
            ) / 1000;

            SET @cellSize = ROUND(0.00001 * @distance, 5);
        ');

        return static::db()->select('
            SELECT
                ROUND(ROUND(`position`.`latitude` / @cellSize) * @cellSize + @cellSize / 2, 5) AS `cell_y`,
                ROUND(ROUND(`position`.`longitude` / @cellSize) * @cellSize + @cellSize / 2, 5) AS `cell_x`,
                COUNT(*) AS `value`
            FROM `position`
            WHERE (
                `position`.`trip_id` IN ('.$tripBuilder->select('id')->toRawSql().')
                AND ST_Within(`position`.`point`, @boundingBox)
            )
            GROUP BY `cell_y`, `cell_x`
            ORDER BY `value` DESC
            LIMIT 10000;
        ');
    }

    /**
     * @param array $bounding_box
     *
     * @return ?array
     */
    public static function heatmapBoundingBox(array $bounding_box): ?array
    {
        if (empty($bounding_box)) {
            return null;
        }

        $bounding_box = [
            'latitude_min' => round(floatval($bounding_box['latitude_min'] ?? 0), 5),
            'longitude_min' => round(floatval($bounding_box['longitude_min'] ?? 0), 5),
            'latitude_max' => round(floatval($bounding_box['latitude_max'] ?? 0), 5),
            'longitude_max' => round(floatval($bounding_box['longitude_max'] ?? 0), 5),
        ];

        if (count($bounding_box) !== count(array_filter($bounding_box))) {
            return null;
        }

        return $bounding_box;
    }
}
