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
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('alarm', 'schedule_start');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->string('schedule_start')->nullable();
            $table->string('schedule_end')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->dropColumn('schedule_start');
            $table->dropColumn('schedule_end');
        });
    }
};
