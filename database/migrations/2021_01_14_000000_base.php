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
        $this->functions();
        $this->tables();
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
    protected function tables()
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

            $table->point('point', 4326)->index();

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
            $table->point('point', 4326)->index();

            $this->timestamps($table);

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

            $table->string('name')->index();
            $table->string('maker')->index();
            $table->string('serial')->unique();
            $table->string('phone_number')->nullable();
            $table->string('password')->default('');

            $table->boolean('enabled')->default(0);

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

            $table->boolean('default')->default(0);
            $table->boolean('enabled')->default(0);

            $this->timestamps($table);
        });

        Schema::create('position', function (Blueprint $table) {
            $table->id();

            $table->point('point', 4326)->index();

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

            $table->dateTime('date_at');

            $this->timestamps($table);

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

            $this->timestamps($table);

            $table->unsignedBigInteger('language_id');
        });

        Schema::create('user_session', function (Blueprint $table) {
            $table->id();

            $table->string('auth')->index();
            $table->string('ip')->index();

            $table->boolean('success')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id')->nullable();
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
     * Set the foreign keys.
     *
     * @return void
     */
    protected function keys()
    {
        Schema::table('alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
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

            $this->foreignOnDeleteCascade($table, 'state');
        });

        Schema::table('device', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
            $this->foreignOnDeleteSetNull($table, 'vehicle');
        });

        Schema::table('device_message', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->spatialIndex('point');

            $this->foreignOnDeleteSetNull($table, 'city');
            $this->foreignOnDeleteSetNull($table, 'device');
            $this->foreignOnDeleteCascade($table, 'timezone');
            $this->foreignOnDeleteCascade($table, 'trip');
            $this->foreignOnDeleteCascade($table, 'user');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('refuel', function (Blueprint $table) {
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
            $this->foreignOnDeleteSetNull($table, 'device');
            $this->foreignOnDeleteCascade($table, 'timezone');
            $this->foreignOnDeleteCascade($table, 'user');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });

        Schema::table('user', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'language');
        });

        Schema::table('user_session', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'user');
        });

        Schema::table('vehicle', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
            $this->foreignOnDeleteCascade($table, 'user');
        });
    }
};
