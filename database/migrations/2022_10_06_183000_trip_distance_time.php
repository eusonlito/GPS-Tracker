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
        return Schema::hasColumn('trip', 'distance');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->unsignedInteger('distance')->default(0);
            $table->unsignedInteger('time')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('distance');
            $table->dropColumn('time');
        });
    }
};
