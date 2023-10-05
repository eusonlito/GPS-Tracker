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
        return Schema::hasColumn('trip', 'timezone_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `trip` SET `timezone_id` = (
                SELECT `device`.`timezone_id`
                FROM `device`
                WHERE `device`.`id` = `trip`.`device_id`
                LIMIT 1
            );
        ');

        Schema::table('trip', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropForeign('trip_timezone_fk');
            $table->dropColumn('timezone_id');
        });
    }
};
