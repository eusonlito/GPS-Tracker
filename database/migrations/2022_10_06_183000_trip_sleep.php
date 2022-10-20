<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Shared\Migration\MigrationAbstract;

return new class extends MigrationAbstract
{
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
        return Schema::hasColumn('trip', 'sleep') === false;
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('sleep');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->boolean('sleep')->default(0);
        });
    }
};