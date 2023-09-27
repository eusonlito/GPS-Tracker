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

        $this->keys();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('device_alarm_notification') === false;
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device_alarm', 'fk_');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $table->unsignedBigInteger('device_alarm_id')->nullable(true)->change();
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'device_alarm');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device_alarm', 'fk_');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $table->unsignedBigInteger('device_alarm_id')->nullable(false)->change();
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device_alarm');
        });
    }
};
