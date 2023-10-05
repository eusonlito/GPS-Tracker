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
        return Schema::hasTable('alarm_vehicle')
            || Schema::hasTable('alarm_device');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `alarm`
            SET `user_id` = (
                SELECT `user_id`
                FROM `device`
                WHERE `device`.`id` = `alarm`.`device_id`
                LIMIT 1
            );
        ');

        Schema::create('alarm_device', function (Blueprint $table) {
            $table->id();

            $this->timestamps($table);

            $table->unsignedBigInteger('alarm_id');
            $table->unsignedBigInteger('device_id');
        });

        $this->db()->unprepared('
            INSERT INTO `alarm_device`
            (`alarm_id`, `device_id`)
            (
                SELECT `alarm`.`id`, `device`.`id`
                FROM `alarm`, `device`
            );
        ');

        Schema::table('alarm', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');

            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });

        Schema::table('alarm', function (Blueprint $table) {
            $table->dropColumn('device_id');
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('alarm_device', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'alarm');
            $this->foreignOnDeleteCascade($table, 'device');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->unsignedBigInteger('device_id')->nullable();

            $this->tableDropForeign($table, 'user', 'fk_');
        });

        $this->db()->unprepared('
            UPDATE `alarm`
            SET `device_id` = (
                SELECT `alarm_device`.`device_id`
                FROM `alarm_device`
                WHERE `alarm_device`.`alarm_id` = `alarm`.`id`
                LIMIT 1
            );
        ');

        Schema::table('alarm', function (Blueprint $table) {
            $table->unsignedBigInteger('device_id')->nullable(false)->change();

            $table->dropColumn('user_id');
        });

        Schema::table('alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });

        Schema::drop('alarm_device');
    }
};
