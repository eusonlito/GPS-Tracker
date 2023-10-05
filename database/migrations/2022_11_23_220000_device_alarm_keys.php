<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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

        $this->tables();
        $this->keys();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('device_alarm') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->db()->unprepared('
            DELETE FROM `device_alarm`
            WHERE `device_id` NOT IN (
                SELECT `id`
                FROM `device`
            );
        ');

        $this->db()->unprepared('
            DELETE FROM `device_alarm_notification`
            WHERE `device_id` NOT IN (
                SELECT `id`
                FROM `device`
            );
        ');

        $this->db()->unprepared('
            DELETE FROM `device_alarm_notification`
            WHERE `device_alarm_id` NOT IN (
                SELECT `id`
                FROM `device_alarm`
            );
        ');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
            $this->foreignOnDeleteCascade($table, 'device_alarm');
            $this->foreignOnDeleteSetNull($table, 'position');
            $this->foreignOnDeleteSetNull($table, 'trip');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');
            $this->tableDropForeign($table, 'device_alarm', 'fk_');
            $this->tableDropForeign($table, 'position', 'fk_');
            $this->tableDropForeign($table, 'trip', 'fk_');
        });
    }
};
