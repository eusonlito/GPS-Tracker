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
        $this->upFinish();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->tablesPosition();
        $this->tablesRefuel();
    }

    /**
     * @return void
     */
    protected function tablesPosition(): void
    {
        if (Schema::hasColumn('position', 'state_id') === false) {
            return;
        }

        Schema::table('position', function (Blueprint $table) {
            $table->dropForeign('position_country_fk');
            $table->dropForeign('position_state_fk');

            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
        });
    }

    /**
     * @return void
     */
    protected function tablesRefuel(): void
    {
        if (Schema::hasColumn('refuel', 'state_id') === false) {
            return;
        }

        Schema::table('refuel', function (Blueprint $table) {
            $table->dropForeign('refuel_country_fk');
            $table->dropForeign('refuel_state_fk');

            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->downPosition();
        $this->downRefuel();
    }

    /**
     * @return void
     */
    protected function downPosition(): void
    {
        if (Schema::hasColumn('position', 'state_id')) {
            return;
        }

        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
        });

        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'country');
            $this->foreignOnDeleteSetNull($table, 'state');
        });

        $this->db()->unprepared('
            UPDATE `position`
            JOIN `city` ON (`city`.`id` = `position`.`city_id`)
            SET
                `position`.`state_id` = `city`.`state_id`,
                `position`.`country_id` = `city`.`country_id`;
        ');
    }

    /**
     * @return void
     */
    protected function downRefuel(): void
    {
        if (Schema::hasColumn('refuel', 'state_id')) {
            return;
        }

        Schema::table('refuel', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
        });

        Schema::table('refuel', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'country');
            $this->foreignOnDeleteSetNull($table, 'state');
        });

        $this->db()->unprepared('
            UPDATE `refuel`
            JOIN `city` ON (`city`.`id` = `refuel`.`city_id`)
            SET
                `refuel`.`state_id` = `city`.`state_id`,
                `refuel`.`country_id` = `city`.`country_id`;
        ');
    }
};
