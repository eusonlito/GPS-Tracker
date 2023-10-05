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
        $this->keys();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('user_fail');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::create('user_fail', function (Blueprint $table) {
            $table->id();

            $table->string('type')->index();
            $table->string('text')->nullable();
            $table->string('ip')->index();

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id')->nullable();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('user_fail', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'user');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::drop('user_fail');
    }
};
