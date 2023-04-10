<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\SharedApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
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
        return Schema::hasColumn('position', 'date_utc_at');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('position', function (Blueprint $table) {
            $table->dateTime('date_utc_at')->nullable();
        });

        $this->db()->statement('
            UPDATE `position` SET `date_utc_at` = DATE_SUB(`date_at`, INTERVAL 2 HOUR);
        ');

        Schema::table('position', function (Blueprint $table) {
            $table->dateTime('date_utc_at')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('position', function (Blueprint $table) {
            $table->dropColumn('date_utc_at');
        });
    }
};
