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
        return Schema::hasColumn('position', 'country_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `position`
            JOIN `city` ON (`city`.`id` = `position`.`city_id`)
            SET
                `position`.`state_id` = `city`.`state_id`,
                `position`.`country_id` = `city`.`country_id`
            WHERE `position`.`city_id` IS NOT NULL;
        ');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'country');
            $this->foreignOnDeleteSetNull($table, 'state');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->dropForeign('position_country_fk');
            $table->dropForeign('position_state_fk');

            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
        });
    }
};
