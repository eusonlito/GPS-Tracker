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
        return Schema::hasColumn('position', 'latitude');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->db()->unprepared('
            ALTER TABLE `alarm_notification`
            ADD COLUMN `latitude` DOUBLE AS (ROUND(ST_LATITUDE(`point`), 5)) STORED,
            ADD COLUMN `longitude` DOUBLE AS (ROUND(ST_LONGITUDE(`point`), 5)) STORED;
        ');

        $this->db()->unprepared('
            ALTER TABLE `city`
            ADD COLUMN `latitude` DOUBLE AS (ROUND(ST_LATITUDE(`point`), 5)) STORED,
            ADD COLUMN `longitude` DOUBLE AS (ROUND(ST_LONGITUDE(`point`), 5)) STORED;
        ');

        $this->db()->unprepared('
            ALTER TABLE `position`
            ADD COLUMN `latitude` DOUBLE AS (ROUND(ST_LATITUDE(`point`), 5)) STORED,
            ADD COLUMN `longitude` DOUBLE AS (ROUND(ST_LONGITUDE(`point`), 5)) STORED;
        ');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->tableAddIndex($table, 'latitude');
            $this->tableAddIndex($table, 'longitude');
        });

        Schema::table('city', function (Blueprint $table) {
            $this->tableAddIndex($table, 'latitude');
            $this->tableAddIndex($table, 'longitude');
        });

        Schema::table('position', function (Blueprint $table) {
            $this->tableAddIndex($table, 'latitude');
            $this->tableAddIndex($table, 'longitude');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });

        Schema::table('city', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
};
