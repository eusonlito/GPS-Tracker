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
        return Schema::hasColumn('refuel', 'position_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `refuel` SET `position_id` = (
                SELECT `position`.`id`
                FROM `position`
                WHERE (
                    `position`.`date_at` <= `refuel`.`date_at`
                    AND `position`.`user_id` = `refuel`.`user_id`
                )
                ORDER BY `position`.`date_at` DESC
                LIMIT 1
            );
        ');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'position');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->dropForeign('refuel_position_fk');
            $table->dropColumn('position_id');
        });
    }
};
