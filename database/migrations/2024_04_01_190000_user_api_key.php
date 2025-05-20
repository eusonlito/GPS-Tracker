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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user', 'api_key');
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('api_key')->nullable()->index()->unique();
            $table->string('api_key_prefix')->nullable();
            $table->boolean('api_key_enabled')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('api_key');
            $table->dropColumn('api_key_prefix');
            $table->dropColumn('api_key_enabled');
        });
    }
};
