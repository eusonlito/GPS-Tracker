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
        return Schema::hasColumn('city', 'country_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `city`
            SET `country_id` = (
                SELECT `state`.`country_id`
                FROM `state`
                WHERE `state`.`id` = `city`.`state_id`
            );
        ');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'country');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $table->dropForeign('city_country_fk');
            $table->dropColumn('country_id');
        });
    }
};
