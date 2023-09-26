<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

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
        Schema::table('maintenance', function (Blueprint $table) {
            $table->date('date_at')->change();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('maintenance', function (Blueprint $table) {
            $table->dateTime('date_at')->change();
        });
    }
};
