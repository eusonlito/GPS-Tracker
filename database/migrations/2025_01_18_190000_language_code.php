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
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('language', 'code') === false;
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->string('code')->unique();
        });
    }
};
