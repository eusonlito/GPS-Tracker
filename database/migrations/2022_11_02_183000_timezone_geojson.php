<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\SharedApp\Migration\MigrationAbstract;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;

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
        $this->index();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('timezone', 'geojson');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->multiPolygon('geojson')->nullable();
        });

        $this->db()->statement('UPDATE `timezone` SET `geojson` = '.TimezoneModel::emptyGeoJSON().';');
        $this->db()->statement('ALTER TABLE `timezone` MODIFY COLUMN `geojson` multipolygon NOT NULL;');
    }

    /**
     * @return void
     */
    protected function index()
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->spatialIndex('geojson');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->dropColumn('geojson');
        });
    }
};
