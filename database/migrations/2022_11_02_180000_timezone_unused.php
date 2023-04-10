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
        return Schema::hasColumn('timezone', 'offset') === false;
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->dropColumn('offset');
            $table->dropColumn('gmt');
            $table->dropColumn('abbr');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->integer('offset');
            $table->string('gmt');
            $table->string('abbr');
        });
    }
};
