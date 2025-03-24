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
        Schema::table('timezone', function (Blueprint $table) {
            $this->tableDropIndex($table, 'geojson');
            $this->tableDropIndex($table, 'geojson', 'spatialindex');
        });

        Schema::table('timezone', function (Blueprint $table) {
            $table->geometry('geojson', 'multipolygon')->invisible(true)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->geometry('geojson', 'multipolygon')->invisible(false)->change();
        });
    }
};
