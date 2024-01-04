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
        $this->db()->unprepared('ALTER TABLE `city` MODIFY COLUMN `point` POINT NOT NULL SRID 4326;');
        $this->db()->unprepared('ALTER TABLE `position` MODIFY COLUMN `point` POINT NOT NULL SRID 4326;');
    }
};
