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
        return Schema::hasTable('file');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::create('file', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('path');

            $table->unsignedBigInteger('size');

            $this->timestamps($table);

            $table->string('related_table');
            $table->unsignedBigInteger('related_id');

            $table->unsignedBigInteger('user_id');
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('file', function (Blueprint $table) {
            $this->tableAddIndex($table, ['related_table', 'related_id']);

            $this->foreignOnDeleteCascade($table, 'user');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::drop('file');
    }
};
