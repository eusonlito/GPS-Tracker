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
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('alarm');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');
            $this->tableDropIndex($table, 'device', 'fk_');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');
            $this->tableDropForeign($table, 'device_alarm', 'fk_');
            $this->tableDropForeign($table, 'position', 'fk_');
            $this->tableDropForeign($table, 'trip', 'fk_');

            $this->tableDropIndex($table, 'device', 'fk_');
            $this->tableDropIndex($table, 'device_alarm', 'fk_');
            $this->tableDropIndex($table, 'position', 'fk_');
            $this->tableDropIndex($table, 'trip', 'fk_');
        });

        Schema::rename('device_alarm', 'alarm');
        Schema::rename('device_alarm_notification', 'alarm_notification');

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->renameColumn('device_alarm_id', 'alarm_id');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'alarm');
            $this->foreignOnDeleteCascade($table, 'device');
            $this->foreignOnDeleteSetNull($table, 'position');
            $this->foreignOnDeleteSetNull($table, 'trip');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'alarm', 'fk_');
            $this->tableDropForeign($table, 'device', 'fk_');
            $this->tableDropForeign($table, 'position', 'fk_');
            $this->tableDropForeign($table, 'trip', 'fk_');

            $this->tableDropIndex($table, 'alarm', 'fk_');
            $this->tableDropIndex($table, 'device', 'fk_');
            $this->tableDropIndex($table, 'position', 'fk_');
            $this->tableDropIndex($table, 'trip', 'fk_');
        });

        Schema::rename('alarm', 'device_alarm');
        Schema::rename('alarm_notification', 'device_alarm_notification');

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $table->renameColumn('alarm_id', 'device_alarm_id');
        });

        Schema::table('device_alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
            $this->foreignOnDeleteSetNull($table, 'device_alarm');
            $this->foreignOnDeleteSetNull($table, 'position');
            $this->foreignOnDeleteSetNull($table, 'trip');
        });
    }
};
