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

        $this->defineTypePoint();
        $this->tables();
        $this->keys();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('refuel', 'point');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->point('point', 4326)->nullable();

            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
        });

        $this->db()->unprepared('
            ALTER TABLE `refuel`
            ADD COLUMN `latitude` DOUBLE AS (ROUND(ST_LATITUDE(`point`), 5)) STORED,
            ADD COLUMN `longitude` DOUBLE AS (ROUND(ST_LONGITUDE(`point`), 5)) STORED;
        ');

        $this->db()->unprepared('
            UPDATE `refuel`
            SET `position_id` = (
                SELECT `position`.`id`
                FROM `position`
                ORDER BY ABS(TIMESTAMPDIFF(SECOND, `refuel`.`date_at`, `position`.`date_at`))
                LIMIT 1
            )
            WHERE `position_id` IS NULL;
        ');

        $this->db()->unprepared('
            UPDATE `refuel`
            JOIN `position` ON (`position`.`id` = `refuel`.`position_id`)
            SET
                `refuel`.`point` = `position`.`point`,
                `refuel`.`city_id` = `position`.`city_id`,
                `refuel`.`state_id` = `position`.`state_id`,
                `refuel`.`country_id` = `position`.`country_id`;
        ');

        Schema::table('refuel', function (Blueprint $table) {
            $table->point('point', 4326)->nullable(false)->index()->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'city');
            $this->foreignOnDeleteSetNull($table, 'country');
            $this->foreignOnDeleteSetNull($table, 'state');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->dropForeign('refuel_city_fk');
            $table->dropForeign('refuel_country_fk');
            $table->dropForeign('refuel_state_fk');

            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('point');

            $table->dropColumn('city_id');
            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
        });
    }
};
