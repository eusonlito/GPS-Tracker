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
        return Schema::hasColumn('language', 'default') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->dropColumn('default');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->boolean('default')->default(0);
        });

        $this->db()->unprepared('
            UPDATE `language`
            SET `default` = TRUE
            LIMIT 1;
        ');
    }
};
