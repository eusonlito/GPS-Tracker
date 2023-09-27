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
        return Schema::hasColumn('trip', 'sleep') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('sleep');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->boolean('sleep')->default(0);
        });
    }
};
