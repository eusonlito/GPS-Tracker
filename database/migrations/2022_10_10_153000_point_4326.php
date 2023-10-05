<?php declare(strict_types=1);

use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->db()->unprepared('ALTER TABLE `city` DROP INDEX `city_point_index`;');
        $this->db()->unprepared('ALTER TABLE `city` MODIFY COLUMN `point` POINT NOT NULL SRID 4326;');
        $this->db()->unprepared('ALTER TABLE `city` ADD SPATIAL INDEX `city_point_index` (`point`) VISIBLE;');

        $this->db()->unprepared('ALTER TABLE `position` DROP INDEX `position_point_index`;');
        $this->db()->unprepared('ALTER TABLE `position` MODIFY COLUMN `point` POINT NOT NULL SRID 4326;');
        $this->db()->unprepared('ALTER TABLE `position` ADD SPATIAL INDEX `position_point_index` (`point`) VISIBLE;');
    }
};
