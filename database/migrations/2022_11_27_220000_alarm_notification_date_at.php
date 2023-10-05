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
        return Schema::hasColumn('alarm_notification', 'date_at');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dateTime('date_at')->nullable();
            $table->dateTime('date_utc_at')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `alarm_notification`
            JOIN `device` ON (`device`.`id` = `alarm_notification`.`device_id`)
            JOIN `timezone` ON (`timezone`.`id` = `device`.`timezone_id`)
            SET
                `alarm_notification`.`date_utc_at` = `alarm_notification`.`created_at`,
                `alarm_notification`.`date_at` = CONVERT_TZ(`alarm_notification`.`created_at`, "UTC", `timezone`.`zone`);
        ');

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dateTime('date_at')->nullable(false)->change();
            $table->dateTime('date_utc_at')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dropColumn('date_at');
            $table->dropColumn('date_utc_at');
        });
    }
};
