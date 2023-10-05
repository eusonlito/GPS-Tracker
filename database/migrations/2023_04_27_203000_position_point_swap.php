<?php declare(strict_types=1);

use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->update();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        try {
            $result = $this->db()->select($this->upMigratedQuery());
        } catch (Exception $e) {
            return false;
        }

        return empty($result)
            || $result[0]->migrated;
    }

    /**
     * @return string
     */
    protected function upMigratedQuery(): string
    {
        return '
            SELECT ST_Y(`point`) = ST_Longitude(`point`) AS `migrated`
            FROM `position`
            ORDER BY `id` ASC
            LIMIT 1;
        ';
    }

    /**
     * @return void
     */
    protected function update(): void
    {
        $this->updateAlarmNotification();
        $this->updateCity();
        $this->updatePosition();
    }

    /**
     * @return void
     */
    protected function updateAlarmNotification(): void
    {
        $this->db()->unprepared('
            DELETE FROM `alarm_notification`
            WHERE ST_Y(`point`) > 90;
        ');

        $this->db()->unprepared('
            UPDATE `alarm_notification`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function updateCity(): void
    {
        $this->db()->unprepared('
            DELETE FROM `city`
            WHERE ST_Y(`point`) > 90;
        ');

        $this->db()->unprepared('
            UPDATE `city`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function updatePosition(): void
    {
        $this->db()->unprepared('
            DELETE FROM `position`
            WHERE ST_Y(`point`) > 90;
        ');

        $this->db()->unprepared('
            DELETE FROM `trip`
            WHERE NOT EXISTS (
                SELECT *
                FROM `position`
                WHERE `position`.`trip_id` = `trip`.`id`
            );
        ');

        $this->db()->unprepared('
            UPDATE `position`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->downAlarmNotification();
        $this->downCity();
        $this->downPosition();
    }

    /**
     * @return void
     */
    protected function downAlarmNotification(): void
    {
        $this->db()->unprepared('
            DELETE FROM `alarm_notification`
            WHERE ST_X(`point`) > 90;
        ');

        $this->db()->unprepared('
            UPDATE `alarm_notification`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function downCity(): void
    {
        $this->db()->unprepared('
            DELETE FROM `city`
            WHERE ST_X(`point`) > 90;
        ');

        $this->db()->unprepared('
            UPDATE `city`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function downPosition(): void
    {
        $this->db()->unprepared('
            DELETE FROM `position`
            WHERE ST_X(`point`) > 90;
        ');

        $this->db()->unprepared('
            UPDATE `position`
            SET `point` = ST_SwapXY(`point`);
        ');
    }
};
