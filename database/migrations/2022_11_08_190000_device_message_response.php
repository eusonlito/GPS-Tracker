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
        Schema::table('device_message', function (Blueprint $table) {
            $table->text('response')->nullable()->change();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('device_message', function (Blueprint $table) {
            $table->string('response')->nullable()->change();
        });
    }
};
