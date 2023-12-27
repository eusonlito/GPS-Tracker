<?php declare(strict_types=1);

namespace App\Domains\Position\Model\Traits;

use App\Domains\Trip\Model\Builder\Trip as TripBuilder;

trait SelectRaw
{
    /**
     * @param \App\Domains\Trip\Model\Builder\Trip $tripBuilder
     * @param array $bounding_box = []
     * @param int $gridSize = 100
     *
     * @return array
     */
    public static function heatmap(TripBuilder $tripBuilder, array $bounding_box = [], ?int $gridSize = 100): array
    {
        $bounding_box = static::heatmapBoundingBox($bounding_box ?: static::tripQueryBoundingBox($tripBuilder));

        if (empty($bounding_box)) {
            return [];
        }

        static::db()->unprepared('
            SET @cellSize = 0.0001;

            SET @boundingBox = ST_SRID(ST_MakeEnvelope(
                Point('.$bounding_box['longitude_min'].', '.$bounding_box['latitude_min'].'),
                Point('.$bounding_box['longitude_max'].', '.$bounding_box['latitude_max'].')
            ), 4326);
        ');

        return static::db()->select('
            SELECT
                ROUND(`latitude` / @cellSize) * @cellSize + @cellSize / 2 AS `latitude`,
                ROUND(`longitude` / @cellSize) * @cellSize + @cellSize / 2 AS `longitude`,
                COUNT(*) AS `value`
            FROM `position`
            WHERE (
                `trip_id` IN ('.$tripBuilder->select('id')->toRawSql().')
                AND ST_Within(`point`, @boundingBox)
            )
            GROUP BY `latitude`, `longitude`
            ORDER BY `value` DESC
            LIMIT 20000;
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
