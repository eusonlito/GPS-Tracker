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
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->unsignedDecimal('price', 7, 3)->change();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->unsignedDecimal('price', 6, 2)->change();
        });
    }
};
