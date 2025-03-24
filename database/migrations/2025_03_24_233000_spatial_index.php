<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->upTables();
        $this->upFinish();
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->spatialIndex('point');
        });

        Schema::table('city', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('city', function (Blueprint $table) {
            $table->spatialIndex('point');
        });

        Schema::table('position', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->spatialIndex('point');
        });

        Schema::table('refuel', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('refuel', function (Blueprint $table) {
            $table->spatialIndex('point');
        });

        Schema::table('timezone', function (Blueprint $table) {
            $this->tableDropIndex($table, 'geojson');
            $this->tableDropIndex($table, 'geojson', 'spatialindex');
        });

        Schema::table('timezone', function (Blueprint $table) {
            $table->spatialIndex('geojson');
        });
    }
};
