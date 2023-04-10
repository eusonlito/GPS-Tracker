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
        return Schema::hasColumn('device', 'connected_at');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dateTimeTz('connected_at')->nullable();
        });

        $this->db()->statement('UPDATE `device` SET `connected_at` = (
            SELECT MAX(`position`.`date_utc_at`)
            FROM `position`
            WHERE `position`.`device_id` = `device`.`id`
        );');
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('connected_at');
        });
    }
};
