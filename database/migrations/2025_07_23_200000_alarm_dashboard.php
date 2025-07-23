<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->upTables();
        $this->upUpdate();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('alarm', 'dashboard');
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->boolean('dashboard')->default(0);
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->boolean('dashboard')->default(0);
        });
    }

    /**
     * @return void
     */
    protected function upUpdate(): void
    {
        $this->db()->unprepared('UPDATE `alarm` SET `dashboard` = true;');
        $this->db()->unprepared('UPDATE `alarm_notification` SET `dashboard` = true;');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->dropColumn('dashboard');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dropColumn('dashboard');
        });
    }
};
