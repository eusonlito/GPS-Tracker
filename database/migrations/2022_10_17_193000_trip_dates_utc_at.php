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

        $this->tables();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('trip', 'start_utc_at');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dateTime('start_utc_at')->nullable();
            $table->dateTime('end_utc_at')->nullable();
        });

        $this->db()->statement('
            UPDATE `trip` SET
                `start_utc_at` = DATE_SUB(`start_at`, INTERVAL 2 HOUR),
                `end_utc_at` = DATE_SUB(`end_at`, INTERVAL 2 HOUR);
        ');

        Schema::table('trip', function (Blueprint $table) {
            $table->dateTime('start_utc_at')->nullable(false)->change();
            $table->dateTime('end_utc_at')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('start_utc_at');
            $table->dropColumn('end_utc_at');
        });
    }
};
