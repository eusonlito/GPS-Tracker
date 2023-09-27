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
        return Schema::hasColumn('device', 'password');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->string('password')->default('');
            $table->unsignedInteger('port')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropColumn('port');
        });
    }
};
