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
        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $table->boolean('state')->default(false)->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $table->boolean('state')->default(null)->nullable(true)->change();
        });
    }
};
