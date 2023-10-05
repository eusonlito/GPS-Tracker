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

        $this->defineTypePoint();
        $this->tables();
        $this->keys();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'timezone_id')
            || Schema::hasTable('vehicle');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `device` SET `timezone_id` = (
                SELECT `timezone`.`id`
                FROM `timezone`
                WHERE `timezone`.`zone` = `device`.`timezone`
                LIMIT 1
            );
        ');

        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('timezone');
            $table->unsignedBigInteger('timezone_id')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->string('timezone')->index();
        });

        $this->db()->unprepared('
            UPDATE `device` SET `timezone` = (
                SELECT `timezone`.`zone`
                FROM `timezone`
                WHERE `timezone`.`id` = `device`.`timezone_id`
                LIMIT 1
            );
        ');

        Schema::table('device', function (Blueprint $table) {
            $table->dropForeign('device_timezone_fk');
            $table->dropColumn('timezone_id');
        });
    }
};
