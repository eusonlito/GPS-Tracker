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

        $this->defineTypePoint();

        $this->tables();
        $this->migrate();
        $this->tablesFinish();
        $this->keys();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('vehicle');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');

            $table->unsignedBigInteger('device_id')->nullable()->change();
            $table->unsignedBigInteger('vehicle_id')->nullable();
        });

        Schema::create('alarm_vehicle', function (Blueprint $table) {
            $table->id();

            $this->timestamps($table);

            $table->unsignedBigInteger('alarm_id');
            $table->unsignedBigInteger('vehicle_id');
        });

        Schema::table('device', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id')->nullable();
        });

        Schema::table('position', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');

            $table->unsignedBigInteger('device_id')->nullable()->change();
            $table->unsignedBigInteger('vehicle_id')->nullable();
        });

        Schema::table('refuel', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id')->nullable();
        });

        Schema::table('trip', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');

            $table->unsignedBigInteger('device_id')->nullable()->change();
            $table->unsignedBigInteger('vehicle_id')->nullable();
        });

        Schema::create('vehicle', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('plate');

            $table->boolean('timezone_auto')->default(0);
            $table->boolean('enabled')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('timezone_id');
            $table->unsignedBigInteger('user_id');
        });
    }

    /**
     * @return void
     */
    protected function migrate(): void
    {
        $this->migrateVehicle();
        $this->migrateDevice();
        $this->migrateAlarmNotification();
        $this->migrateAlarmVehicle();
        $this->migratePosition();
        $this->migrateRefuel();
        $this->migrateTrip();
    }

    /**
     * @return void
     */
    protected function migrateVehicle(): void
    {
        $this->db()->unprepared('
            INSERT INTO `vehicle`
            (`id`, `name`, `plate`, `timezone_auto`, `enabled`, `created_at`, `updated_at`, `timezone_id`, `user_id`)
            (
                SELECT `id`, `name`, "", `timezone_auto`, `enabled`, `created_at`, `updated_at`, `timezone_id`, `user_id`
                FROM `device`
            );
        ');
    }

    /**
     * @return void
     */
    protected function migrateDevice(): void
    {
        $this->db()->unprepared('
            UPDATE `device`
            SET `vehicle_id` = `id`;
        ');
    }

    /**
     * @return void
     */
    protected function migrateAlarmNotification(): void
    {
        $this->db()->unprepared('
            UPDATE `alarm_notification`
            SET `vehicle_id` = `device_id`;
        ');
    }

    /**
     * @return void
     */
    protected function migrateAlarmVehicle(): void
    {
        $this->db()->unprepared('
            INSERT INTO `alarm_vehicle`
            (`alarm_id`, `vehicle_id`)
            (
                SELECT `alarm_id`, `device_id`
                FROM `alarm_device`
            );
        ');
    }

    /**
     * @return void
     */
    protected function migratePosition(): void
    {
        $this->db()->unprepared('
            UPDATE `position`
            SET `vehicle_id` = `device_id`;
        ');
    }

    /**
     * @return void
     */
    protected function migrateRefuel(): void
    {
        $this->db()->unprepared('
            UPDATE `refuel`
            SET `vehicle_id` = `device_id`;
        ');
    }

    /**
     * @return void
     */
    protected function migrateTrip(): void
    {
        $this->db()->unprepared('
            UPDATE `trip`
            SET `vehicle_id` = `device_id`;
        ');
    }

    /**
     * @return void
     */
    protected function tablesFinish(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dropColumn('device_id');

            $table->unsignedBigInteger('vehicle_id')->nullable(false)->change();
        });

        Schema::drop('alarm_device');

        Schema::table('device', function (Blueprint $table) {
            $this->tableDropForeign($table, 'timezone', 'fk_');

            $table->dropColumn('timezone_id');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id')->nullable(false)->change();
        });

        Schema::table('refuel', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');

            $table->dropColumn('device_id');

            $table->unsignedBigInteger('vehicle_id')->nullable(false)->change();
        });

        Schema::table('trip', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'alarm');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('device', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'vehicle');
        });

        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'device');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('refuel', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('trip', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'device');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('vehicle', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
            $this->foreignOnDeleteCascade($table, 'user');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
    }
};
