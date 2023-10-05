<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;

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
        return Schema::hasColumn('timezone', 'geojson');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->multiPolygon('geojson')->nullable();
        });

        $this->db()->unprepared('UPDATE `timezone` SET `geojson` = '.TimezoneModel::emptyGeoJSON().';');
        $this->db()->unprepared('ALTER TABLE `timezone` MODIFY COLUMN `geojson` multipolygon NOT NULL;');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->spatialIndex('geojson');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->dropColumn('geojson');
        });
    }
};
