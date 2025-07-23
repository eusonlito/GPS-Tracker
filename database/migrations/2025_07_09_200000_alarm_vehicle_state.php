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
        if ($this->upMigrated()) {
            return;
        }

        $this->upTables();
        $this->upKeys();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('alarm_vehicle', 'state');
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $table->boolean('state')->default(0);
        });
    }

    /**
     * @return void
     */
    protected function upKeys(): void
    {
        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $this->tableAddUnique($table, ['alarm_id', 'vehicle_id']);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $table->dropColumn('state');
        });

        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $this->tableDropIndex($table, ['alarm_id', 'vehicle_id']);
        });
    }
};
