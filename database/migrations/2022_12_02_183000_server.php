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
        return Schema::hasTable('server');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::create('server', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('port')->default(0);
            $table->string('protocol');

            $table->boolean('enabled')->default(0);

            $this->timestamps($table);
        });

        $this->db()->statement('
            INSERT INTO `server`
            SET `port` = 8091, `protocol` = "h02", `enabled` = true;
        ');
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::drop('server');
    }
};
