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
        $this->defineTypePoint();
        $this->functions();
        $this->tables();
        $this->unprepared();
        $this->keys();
        $this->upFinish();
    }

    /**
     * @return void
     */
    protected function functions(): void
    {
        $this->database()->functionUpdatedAtNow();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::create('alarm', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('type');

            $table->string('schedule_start')->nullable();
            $table->string('schedule_end')->nullable();

            $table->jsonb('config')->nullable();

            $table->boolean('telegram')->default(0);
            $table->boolean('enabled')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id');
        });

        Schema::create('alarm_notification', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('type');

            $table->jsonb('config')->nullable();

            $table->point('point', 4326);

            $table->boolean('telegram')->default(0);

            $table->dateTime('date_at');
            $table->dateTime('date_utc_at');
            $table->dateTime('closed_at')->nullable();
            $table->dateTime('sent_at')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('alarm_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->unsignedBigInteger('vehicle_id');
        });

        Schema::create('alarm_vehicle', function (Blueprint $table) {
            $table->id();

            $this->timestamps($table);

            $table->unsignedBigInteger('alarm_id');
            $table->unsignedBigInteger('vehicle_id');
        });

        Schema::create('city', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->jsonb('alias')->nullable();

            $table->point('point', 4326);

            $this->timestamps($table);

            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id');
        });

        Schema::create('configuration', function (Blueprint $table) {
            $table->id();

            $table->string('key')->unique();
            $table->string('value')->default('');
            $table->string('description')->default('');

            $this->timestamps($table);
        });

        Schema::create('country', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name')->index();
            $table->jsonb('alias')->nullable();

            $this->timestamps($table);
        });

        Schema::create('device', function (Blueprint $table) {
            $table->id();

            $table->string('code')->index()->nullable();

            $table->string('name')->index();
            $table->string('model')->index();
            $table->string('serial')->unique();
            $table->string('phone_number')->nullable();
            $table->string('password')->default('');

            $table->boolean('enabled')->default(0);
            $table->boolean('shared')->default(0);
            $table->boolean('shared_public')->default(0);

            $table->dateTimeTz('connected_at')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vehicle_id')->nullable();
        });

        Schema::create('device_message', function (Blueprint $table) {
            $table->id();

            $table->string('message');
            $table->text('response')->nullable();

            $table->dateTime('sent_at')->nullable();
            $table->dateTime('response_at')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('device_id');
        });

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

        Schema::create('ip_lock', function (Blueprint $table) {
            $table->id();

            $table->string('ip')->default('')->index();

            $table->dateTimeTz('end_at')->nullable();

            $this->timestamps($table);
        });

        Schema::create('language', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code')->unique();
            $table->string('locale')->unique();

            $table->boolean('enabled')->default(0);

            $this->timestamps($table);
        });

        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('workshop')->default('');

            $table->text('description');

            $table->date('date_at');

            $table->unsignedDecimal('amount', 10, 2)->default(0);

            $table->unsignedDecimal('distance', 10, 2)->default(0);
            $table->unsignedDecimal('distance_next', 10, 2)->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vehicle_id');
        });

        Schema::create('maintenance_item', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id');
        });

        Schema::create('maintenance_maintenance_item', function (Blueprint $table) {
            $table->id();

            $table->unsignedDecimal('quantity', 10, 2)->default(0);
            $table->unsignedDecimal('amount_gross', 10, 2)->default(0);
            $table->unsignedDecimal('amount_net', 10, 2)->default(0);
            $table->unsignedDecimal('tax_percent', 10, 2)->default(0);
            $table->unsignedDecimal('tax_amount', 10, 2)->default(0);
            $table->unsignedDecimal('subtotal', 10, 2)->default(0);
            $table->unsignedDecimal('total', 10, 2)->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('maintenance_id');
            $table->unsignedBigInteger('maintenance_item_id');
        });

        Schema::create('position', function (Blueprint $table) {
            $table->id();

            $table->point('point', 4326);

            $table->unsignedDecimal('speed', 6, 2);

            $table->unsignedInteger('direction');
            $table->unsignedInteger('signal');

            $table->dateTime('date_at');
            $table->dateTime('date_utc_at');

            $this->timestamps($table);

            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->unsignedBigInteger('timezone_id');
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vehicle_id');
        });

        Schema::create('queue_fail', function (Blueprint $table) {
            $table->id();

            $table->text('connection');
            $table->text('queue');

            $table->longText('payload');
            $table->longText('exception');

            $table->dateTime('failed_at')->useCurrent();

            $this->timestamps($table);
        });

        Schema::create('refuel', function (Blueprint $table) {
            $table->id();

            $table->unsignedDecimal('distance_total', 10, 2);
            $table->unsignedDecimal('distance', 6, 2);
            $table->unsignedDecimal('quantity', 6, 2);
            $table->unsignedDecimal('quantity_before', 6, 2);
            $table->unsignedDecimal('price', 7, 3);
            $table->unsignedDecimal('total', 6, 2);

            $table->point('point', 4326);

            $table->dateTime('date_at');

            $this->timestamps($table);

            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vehicle_id');
        });

        Schema::create('server', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('port')->default(0);
            $table->string('protocol');

            $table->boolean('debug')->default(0);
            $table->boolean('enabled')->default(0);

            $this->timestamps($table);
        });

        Schema::create('state', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->jsonb('alias')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('country_id');
        });

        Schema::create('timezone', function (Blueprint $table) {
            $table->id();

            $table->string('zone')->index();
            $table->multiPolygon('geojson');

            $table->boolean('default')->default(0);

            $this->timestamps($table);
        });

        Schema::create('trip', function (Blueprint $table) {
            $table->id();

            $table->string('code')->index()->nullable();
            $table->string('name')->index();

            $table->unsignedInteger('distance')->default(0);
            $table->unsignedInteger('time')->default(0);

            $table->jsonb('stats')->nullable();

            $table->dateTime('start_at');
            $table->dateTime('start_utc_at');
            $table->dateTime('end_at');
            $table->dateTime('end_utc_at');

            $table->boolean('shared')->default(0);
            $table->boolean('shared_public')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('device_id')->nullable();
            $table->unsignedBigInteger('timezone_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vehicle_id');
        });

        Schema::create('user', function (Blueprint $table) {
            $table->id();

            $table->string('name')->default('');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token')->nullable();

            $table->jsonb('preferences')->nullable();
            $table->jsonb('telegram')->nullable();

            $table->boolean('enabled')->default(0);

            $table->boolean('admin')->default(0);
            $table->boolean('admin_mode')->default(0);

            $table->boolean('manager')->default(0);
            $table->boolean('manager_mode')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('timezone_id');
        });

        Schema::create('user_fail', function (Blueprint $table) {
            $table->id();

            $table->string('type')->index();
            $table->string('text')->nullable();
            $table->string('ip')->index();

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::create('user_session', function (Blueprint $table) {
            $table->id();

            $table->string('auth')->index();
            $table->string('ip')->index();

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id');
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
    protected function unprepared(): void
    {
        $this->db()->unprepared('
            ALTER TABLE `alarm_notification`
            ADD COLUMN `latitude` DOUBLE AS (ROUND(ST_LATITUDE(`point`), 5)) STORED,
            ADD COLUMN `longitude` DOUBLE AS (ROUND(ST_LONGITUDE(`point`), 5)) STORED;
        ');

        $this->db()->unprepared('
            ALTER TABLE `city`
            ADD COLUMN `latitude` DOUBLE AS (ROUND(ST_LATITUDE(`point`), 5)) STORED,
            ADD COLUMN `longitude` DOUBLE AS (ROUND(ST_LONGITUDE(`point`), 5)) STORED;
        ');

        $this->db()->unprepared('
            ALTER TABLE `position`
            ADD COLUMN `latitude` DOUBLE AS (ROUND(ST_LATITUDE(`point`), 5)) STORED,
            ADD COLUMN `longitude` DOUBLE AS (ROUND(ST_LONGITUDE(`point`), 5)) STORED;
        ');

        $this->db()->unprepared('
            ALTER TABLE `refuel`
            ADD COLUMN `latitude` DOUBLE AS (ROUND(ST_LATITUDE(`point`), 5)) STORED,
            ADD COLUMN `longitude` DOUBLE AS (ROUND(ST_LONGITUDE(`point`), 5)) STORED;
        ');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->spatialIndex('point');

            $this->tableAddIndex($table, 'latitude');
            $this->tableAddIndex($table, 'longitude');

            $this->foreignOnDeleteSetNull($table, 'alarm');
            $this->foreignOnDeleteSetNull($table, 'position');
            $this->foreignOnDeleteSetNull($table, 'trip');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'alarm');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('city', function (Blueprint $table) {
            $table->spatialIndex('point');

            $this->tableAddIndex($table, 'latitude');
            $this->tableAddIndex($table, 'longitude');

            $this->foreignOnDeleteCascade($table, 'country');
            $this->foreignOnDeleteCascade($table, 'state');
        });

        Schema::table('device', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
            $this->foreignOnDeleteSetNull($table, 'vehicle');
        });

        Schema::table('device_message', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });

        Schema::table('file', function (Blueprint $table) {
            $this->tableAddIndex($table, ['related_table', 'related_id']);

            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('maintenance', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('maintenance_item', function (Blueprint $table) {
            $this->tableAddUnique($table, ['name', 'user_id']);

            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('maintenance_maintenance_item', function (Blueprint $table) {
            $this->tableAddUnique($table, ['maintenance_id', 'maintenance_item_id']);

            $this->foreignOnDeleteCascade($table, 'maintenance');
            $this->foreignOnDeleteCascade($table, 'maintenance_item');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->spatialIndex('point');

            $this->tableAddIndex($table, 'latitude');
            $this->tableAddIndex($table, 'longitude');

            $this->foreignOnDeleteSetNull($table, 'city');
            $this->foreignOnDeleteSetNull($table, 'device');
            $this->foreignOnDeleteCascade($table, 'timezone');
            $this->foreignOnDeleteCascade($table, 'trip');
            $this->foreignOnDeleteCascade($table, 'user');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('refuel', function (Blueprint $table) {
            $table->spatialIndex('point');

            $this->foreignOnDeleteSetNull($table, 'city');
            $this->foreignOnDeleteSetNull($table, 'position');
            $this->foreignOnDeleteCascade($table, 'user');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('state', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'country');
        });

        Schema::table('timezone', function (Blueprint $table) {
            $table->spatialIndex('geojson');
        });

        Schema::table('trip', function (Blueprint $table) {
            $this->tableAddIndex($table, ['shared_public', 'shared', 'device_id', 'end_utc_at']);

            $this->foreignOnDeleteSetNull($table, 'device');
            $this->foreignOnDeleteCascade($table, 'timezone');
            $this->foreignOnDeleteCascade($table, 'user');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('user', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'language');
            $this->foreignOnDeleteCascade($table, 'timezone');
        });

        Schema::table('user_fail', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'user');
        });

        Schema::table('user_session', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('vehicle', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
            $this->foreignOnDeleteCascade($table, 'user');
        });
    }
};
