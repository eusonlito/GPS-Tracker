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
        $this->tables();
        $this->upFinish();
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('ip_lock', function (Blueprint $table) {
            $this->tableAddIndex($table, 'ip');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('ip_lock', function (Blueprint $table) {
            $this->tableAddIndex($table, 'ip');
        });
    }
};
