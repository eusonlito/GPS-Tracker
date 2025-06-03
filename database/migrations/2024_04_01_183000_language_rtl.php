<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('language', 'rtl');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->boolean('rtl')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->dropColumn('rtl');
        });
    }
};
