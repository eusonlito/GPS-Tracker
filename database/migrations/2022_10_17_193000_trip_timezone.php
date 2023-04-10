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
    protected function tables()
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable();
        });

        $this->db()->statement('
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
    public function keys()
    {
        Schema::table('trip', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropForeign('trip_timezone_fk');
            $table->dropColumn('timezone_id');
        });
    }
};
