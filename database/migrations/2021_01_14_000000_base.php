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
            $table->string('password')->default('');

            $table->unsignedInteger('port')->default(0);

            $table->boolean('timezone_auto')->default(0);
            $table->boolean('enabled')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('timezone_id');
            $table->unsignedBigInteger('user_id');
        });

        Schema::create('ip_lock', function (Blueprint $table) {
            $table->id();

            $table->string('ip')->default('');

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
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('timezone_id');
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->unsignedBigInteger('user_id');
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

            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('user_id');
        });

        Schema::create('timezone', function (Blueprint $table) {
            $table->id();

            $table->string('zone')->index();
            $table->integer('offset');
            $table->string('gmt');
            $table->string('abbr');

            $this->timestamps($table);
        });

        Schema::create('trip', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();

            $table->unsignedInteger('distance')->default(0);
            $table->unsignedInteger('time')->default(0);

            $table->jsonb('stats')->nullable();

            $table->dateTime('start_at');
            $table->dateTime('start_utc_at');
            $table->dateTime('end_at');
            $table->dateTime('end_utc_at');

            $this->timestamps($table);

            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('timezone_id');
            $table->unsignedBigInteger('user_id');
        });

        Schema::create('state', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->jsonb('alias')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('country_id');
        });

        Schema::create('user', function (Blueprint $table) {
            $table->id();

            $table->string('name')->default('');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token')->nullable();

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
    }

    /**
     * Set the foreign keys.
     *
     * @return void
     */
    protected function keys()
    {
        Schema::table('city', function (Blueprint $table) {
            $table->spatialIndex('point');

            $this->foreignOnDeleteCascade($table, 'state');
        });

        Schema::table('device', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->spatialIndex('point');

            $this->foreignOnDeleteSetNull($table, 'city');
            $this->foreignOnDeleteCascade($table, 'device');
            $this->foreignOnDeleteCascade($table, 'timezone');
            $this->foreignOnDeleteSetNull($table, 'trip');
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('refuel', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('state', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'country');
        });

        Schema::table('trip', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
            $this->foreignOnDeleteCascade($table, 'timezone');
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('user', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'language');
        });

        Schema::table('user_session', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'user');
        });
    }
};
