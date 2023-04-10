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
        $this->delete();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('server', 'debug');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('server', function (Blueprint $table) {
            $table->boolean('debug')->default(0);
        });
    }

    /**
     * @return void
     */
    protected function delete()
    {
        $this->db()->statement('
            DELETE FROM `configuration`
            WHERE `key` = "server_debug"
            LIMIT 1;
        ');
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('server', function (Blueprint $table) {
            $table->dropColumn('debug');
        });
    }
};
