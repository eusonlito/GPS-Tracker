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
        $this->defineTypePoint();
        $this->tables();
        $this->upFinish();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->db()->unprepared('DELETE FROM `position` WHERE `trip_id` IS NULL;');

        Schema::table('position', function (Blueprint $table) {
            $this->tableDropForeign($table, 'trip', 'fk');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('trip_id')->nullable(false)->change();
        });

        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'trip');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->defineTypePoint();

        Schema::table('position', function (Blueprint $table) {
            $this->tableDropForeign($table, 'trip', 'fk');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('trip_id')->nullable(true)->change();
        });

        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'trip');
        });
    }
};
