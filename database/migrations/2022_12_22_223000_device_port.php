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

        $this->defineTypePoint();
        $this->tables();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'port') === false;
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('port');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('device', function (Blueprint $table) {
            $table->unsignedInteger('port')->default(0);
        });
    }
};
