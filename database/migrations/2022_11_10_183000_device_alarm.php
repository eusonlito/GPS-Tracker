<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Shared\Migration\MigrationAbstract;

return new class extends MigrationAbstract
{
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
        return Schema::hasTable('device_alarm');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::create('device_alarm', function (Blueprint $table) {
            $table->id();

            $table->string('type');

            $table->jsonb('config')->nullable();

            $table->boolean('enabled')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('device_id');
        });

        Schema::create('device_alarm_notification', function (Blueprint $table) {
            $table->id();

            $table->jsonb('config')->nullable();

            $table->dateTime('sent_at')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('device_alarm_id');
        });
    }

    /**
     * @return void
     */
    protected function keys()
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
            $this->foreignOnDeleteCascade($table, 'device_alarm');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::drop('device_alarm_notification');
        Schema::drop('device_alarm');
    }
};
