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
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('timezone', 'default');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->boolean('default')->default(0);
        });

        $this->db()->statement('
            UPDATE `timezone`
            SET `default` = true
            WHERE `zone` = (
                SELECT `value`
                FROM `configuration`
                WHERE `key` = "timezone_default"
                LIMIT 1
            );
        ');

        $this->db()->statement('
            DELETE FROM `configuration`
            WHERE `key` = "timezone_default";
        ');
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->dropColumn('default');
        });

        $this->db()->statement('
            INSERT INTO `configuration`
            SET
                `key` = "timezone_default",
                `value` = "Europe/Madrid",
                `description` = "Zona Horaria por defecto de la Plataforma";
        ');
    }
};
