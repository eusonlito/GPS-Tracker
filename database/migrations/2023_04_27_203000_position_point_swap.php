<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\SharedApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up()
    {
        $this->update();
        $this->upFinish();
    }

    /**
     * @return void
     */
    protected function update()
    {
        $this->updateAlarmNotification();
        $this->updateCity();
        $this->updatePosition();
    }

    /**
     * @return void
     */
    protected function updateAlarmNotification()
    {
        $this->db()->statement('
            DELETE FROM `alarm_notification`
            WHERE ST_Y(`point`) > 90;
        ');

        $this->db()->statement('
            UPDATE `alarm_notification`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function updateCity()
    {
        $this->db()->statement('
            DELETE FROM `city`
            WHERE ST_Y(`point`) > 90;
        ');

        $this->db()->statement('
            UPDATE `city`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function updatePosition()
    {
        $this->db()->statement('
            DELETE FROM `position`
            WHERE ST_Y(`point`) > 90;
        ');

        $this->db()->statement('
            DELETE FROM `trip`
            WHERE NOT EXISTS (
                SELECT *
                FROM `position`
                WHERE `position`.`trip_id` = `trip`.`id`
            );
        ');

        $this->db()->statement('
            UPDATE `position`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->downAlarmNotification();
        $this->downCity();
        $this->downPosition();
    }

    /**
     * @return void
     */
    protected function downAlarmNotification()
    {
        $this->db()->statement('
            DELETE FROM `alarm_notification`
            WHERE ST_X(`point`) > 90;
        ');

        $this->db()->statement('
            UPDATE `alarm_notification`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function downCity()
    {
        $this->db()->statement('
            DELETE FROM `city`
            WHERE ST_X(`point`) > 90;
        ');

        $this->db()->statement('
            UPDATE `city`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function downPosition()
    {
        $this->db()->statement('
            DELETE FROM `position`
            WHERE ST_X(`point`) > 90;
        ');

        $this->db()->statement('
            UPDATE `position`
            SET `point` = ST_SwapXY(`point`);
        ');
    }
};
