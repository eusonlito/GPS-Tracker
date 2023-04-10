<?php declare(strict_types=1);

use App\Domains\SharedApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up()
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables()
    {
        $this->db()->statement('ALTER TABLE `city` DROP INDEX `city_point_index`;');
        $this->db()->statement('ALTER TABLE `city` MODIFY COLUMN `point` POINT NOT NULL SRID 4326;');
        $this->db()->statement('ALTER TABLE `city` ADD SPATIAL INDEX `city_point_index` (`point`) VISIBLE;');

        $this->db()->statement('ALTER TABLE `position` DROP INDEX `position_point_index`;');
        $this->db()->statement('ALTER TABLE `position` MODIFY COLUMN `point` POINT NOT NULL SRID 4326;');
        $this->db()->statement('ALTER TABLE `position` ADD SPATIAL INDEX `position_point_index` (`point`) VISIBLE;');
    }
};
