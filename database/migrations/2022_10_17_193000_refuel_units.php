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
        return Schema::hasColumn('refuel', 'distance_total');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->renameColumn('kilometers', 'distance_total');
            $table->renameColumn('litres', 'quantity');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->renameColumn('distance_total', 'kilometers');
            $table->renameColumn('quantity', 'litres');
        });
    }
};
