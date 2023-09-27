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
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('device_alarm');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::create('device_alarm', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('type');

            $table->jsonb('config')->nullable();

            $table->boolean('enabled')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('device_id');
        });

        Schema::create('device_alarm_notification', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('type');

            $table->jsonb('config')->nullable();

            $table->dateTime('closed_at')->nullable();
            $table->dateTime('sent_at')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('device_alarm_id');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('trip_id')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::drop('device_alarm_notification');
        Schema::drop('device_alarm');
    }
};
