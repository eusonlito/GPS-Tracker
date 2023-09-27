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
        $this->keys();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('position', 'city_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->nullable();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'city');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->dropForeign('position_city_fk');
            $table->dropColumn('city_id');
        });
    }
};
