<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Shared\Migration\MigrationAbstract;

return new class extends MigrationAbstract
{
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
        return Schema::hasTable('alarm_device');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::create('alarm_device', function (Blueprint $table) {
            $table->id();

            $this->timestamps($table);

            $table->unsignedBigInteger('alarm_id');
            $table->unsignedBigInteger('device_id');
        });

        $this->db()->statement('
            INSERT INTO `alarm_device`
            (`alarm_id`, `device_id`)
            (
                SELECT `alarm`.`id`, `device`.`id`
                FROM `alarm`, `device`
            );
        ');

        Schema::table('alarm', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');

            $table->dropColumn('device_id');
        });
    }

    /**
     * @return void
     */
    protected function keys()
    {
        Schema::table('alarm_device', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'alarm');
            $this->foreignOnDeleteCascade($table, 'device');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->unsignedBigInteger('device_id')->nullable();
        });

        $this->db()->statement('
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
        });

        Schema::table('alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });

        Schema::drop('alarm_device');
    }
};
