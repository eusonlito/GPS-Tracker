<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Shared\Migration\MigrationAbstract;

return new class extends MigrationAbstract
{
    /**
     * @return void
     */
    public function up()
    {
        $this->map();
        $this->tables();
        $this->upFinish();
    }

    /**
     * @return void
     */
    protected function map()
    {
        $this->db()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('point', 'array');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        $this->db()->statement('DELETE FROM `position` WHERE `trip_id` IS NULL;');

        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('trip_id')->nullable(false)->change();
        });

        Schema::table('position', function (Blueprint $table) {
            $this->tableDropForeign($table, 'trip', 'fk');
            $this->foreignOnDeleteCascade($table, 'trip');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->map();

        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('trip_id')->nullable(true)->change();
        });

        Schema::table('position', function (Blueprint $table) {
            $this->tableDropForeign($table, 'trip', 'fk');
            $this->foreignOnDeleteSetNull($table, 'trip');
        });
    }
};
