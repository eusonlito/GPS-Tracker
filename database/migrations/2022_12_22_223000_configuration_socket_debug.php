<?php declare(strict_types=1);

use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->db()->unprepared('
            DELETE FROM `configuration`
            WHERE `key` = "socket_debug"
            LIMIT 1;
        ');
    }
};
