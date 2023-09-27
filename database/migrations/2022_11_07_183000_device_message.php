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
        return Schema::hasTable('device_message');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::create('device_message', function (Blueprint $table) {
            $table->id();

            $table->string('message');
            $table->string('response')->nullable();

            $table->dateTime('sent_at')->nullable();
            $table->dateTime('response_at')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('device_id');
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('device_message', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::drop('device_message');
    }
};
