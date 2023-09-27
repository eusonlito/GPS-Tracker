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
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->unsignedDecimal('price', 7, 3)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->unsignedDecimal('price', 6, 2)->change();
        });
    }
};
