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
        return Schema::hasColumn('refuel', 'quantity_before');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->unsignedDecimal('quantity_before', 6, 2);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->dropColumn('quantity_before');
        });
    }
};
