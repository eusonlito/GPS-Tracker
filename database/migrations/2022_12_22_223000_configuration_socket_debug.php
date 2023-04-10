<?php declare(strict_types=1);

use App\Domains\SharedApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up()
    {
        $this->db()->statement('
            DELETE FROM `configuration`
            WHERE `key` = "socket_debug"
            LIMIT 1;
        ');
    }
};
