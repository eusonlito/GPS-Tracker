<?php declare(strict_types=1);

namespace App\Domains\Trip\Model\Traits;

trait Statement
{
    /**
     * @return void
     */
    public function updateDistanceTime(): void
    {
        static::db()->statement('
            UPDATE `trip`, (
                WITH `summary` AS (
                    SELECT `trip_id`, ST_Distance(
                        LAG(`point`) OVER (PARTITION BY `trip_id` ORDER BY `date_utc_at` ASC),
                        `point`
                    ) AS `distance`
                    FROM `position`
                    WHERE `trip_id` = :trip_id
                    ORDER BY `date_utc_at` ASC
                )
                SELECT `trip_id`, ROUND(COALESCE(SUM(`distance`), 0)) `distance`
                FROM `summary`
                GROUP BY `trip_id`
            ) `summary`
            SET
                `trip`.`distance` = `summary`.`distance`,
                `trip`.`time` = UNIX_TIMESTAMP(`trip`.`end_utc_at`) - UNIX_TIMESTAMP(`trip`.`start_utc_at`)
            WHERE
                `trip`.`id` = `summary`.`trip_id`;
        ', ['trip_id' => $this->id]);
    }
}
