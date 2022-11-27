<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\SharedApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract
{
    /**
     * @return void
     */
    public function up()
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->defineTypePoint();
        $this->tables();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('alarm_notification', 'point');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->point('point', 4326)->nullable();
        });

        $this->db()->statement('
            UPDATE `alarm_notification`
            JOIN `position` ON (`position`.`id` = `alarm_notification`.`position_id`)
            SET `alarm_notification`.`point` = `position`.`point`;
        ');

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->point('point', 4326)->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dropColumn('point');
        });
    }
};
