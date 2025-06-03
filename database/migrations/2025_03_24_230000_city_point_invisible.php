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
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('city', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->invisible(true)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->invisible(false)->change();
        });
    }
};
