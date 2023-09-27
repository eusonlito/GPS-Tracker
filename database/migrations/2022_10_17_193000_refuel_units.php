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

        $this->tables();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('refuel', 'distance_total');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->renameColumn('kilometers', 'distance_total');
            $table->renameColumn('litres', 'quantity');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->renameColumn('distance_total', 'kilometers');
            $table->renameColumn('quantity', 'litres');
        });
    }
};
