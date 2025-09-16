
Source Trees:

/database:
(Files/directories marked with ❌ are excluded or not included here)

database/
├── .dockerignore
├── .gitignore ❌
├── Seeders/
│   └── Database.php
├── migrations/
│   ├── 2021_01_14_000000_base.php
│   ├── 2021_01_14_000001_seed.php
│   ├── 2022_10_04_184500_device_password_port.php
│   ├── 2022_10_06_183000_trip_distance_time.php
│   ├── 2022_10_06_183000_trip_sleep.php
│   ├── 2022_10_07_190000_city_state_country.php
│   ├── 2022_10_07_193000_position_city.php
│   ├── 2022_10_09_233000_device_timezone.php
│   ├── 2022_10_10_153000_point_4326.php
│   ├── 2022_10_11_173000_user_admin.php
│   ├── 2022_10_16_190000_timezone.php
│   ├── 2022_10_16_193000_device_timezone.php
│   ├── 2022_10_16_193000_position_date_utc_at.php
│   ├── 2022_10_16_193000_position_timezone.php
│   ├── 2022_10_17_193000_refuel_units.php
│   ├── 2022_10_17_193000_trip_dates_utc_at.php
│   ├── 2022_10_17_193000_trip_timezone.php
│   ├── 2022_10_17_230000_refuel_quantity_before.php
│   ├── 2022_10_17_233000_refuel_price.php
│   ├── 2022_11_01_193000_device_timezone_auto.php
│   ├── 2022_11_02_180000_timezone_unused.php
│   ├── 2022_11_02_183000_timezone_geojson.php
│   ├── 2022_11_04_183000_device_connected_at.php
│   ├── 2022_11_05_220000_position_trip_id.php
│   ├── 2022_11_07_183000_device_message.php
│   ├── 2022_11_08_190000_device_message_response.php
│   ├── 2022_11_09_183000_device_phone_number.php
│   ├── 2022_11_10_183000_device_alarm.php
│   ├── 2022_11_23_220000_device_alarm_keys.php
│   ├── 2022_11_23_233000_user_telegram.php
│   ├── 2022_11_24_183000_device_alarm_telegram.php
│   ├── 2022_11_24_220000_device_alarm_notification_foreign.php
│   ├── 2022_11_25_223000_device_alarm_rename.php
│   ├── 2022_11_25_224000_device_alarm_multiple.php
│   ├── 2022_11_27_190000_timezone_default.php
│   ├── 2022_11_27_220000_alarm_notification_date_at.php
│   ├── 2022_11_27_223000_alarm_notification_point.php
│   ├── 2022_12_02_183000_server.php
│   ├── 2022_12_20_183000_vehicle.php
│   ├── 2022_12_22_223000_configuration_socket_debug.php
│   ├── 2022_12_22_223000_device_port.php
│   ├── 2022_12_27_183000_server_debug.php
│   ├── 2022_12_29_220000_trip_stats.php
│   ├── 2023_01_02_230000_user_preferences.php
│   ├── 2023_02_01_230000_trip_shared.php
│   ├── 2023_02_07_234500_device_timezone_auto.php
│   ├── 2023_03_09_163000_alarm_schedule.php
│   ├── 2023_03_22_183000_ip_lock_index.php
│   ├── 2023_04_27_203000_position_point_swap.php
│   ├── 2023_09_13_223000_maintenance.php
│   ├── 2023_09_14_190000_file.php
│   ├── 2023_09_15_183000_maintenance_date_at.php
│   ├── 2023_09_25_200000_device_shared.php
│   ├── 2023_09_27_004500_device_maker_model.php
│   ├── 2023_09_27_005000_device_trip_shared_public.php
│   ├── 2023_09_27_185000_device_trip_code_uuid.php
│   ├── 2023_09_29_185000_position_index.php
│   ├── 2023_10_02_185000_position_index.php
│   ├── 2023_10_05_185000_user_fail.php
│   ├── 2023_10_05_190000_user_session_to_user_fail.php
│   ├── 2023_10_05_235000_trip_index.php
│   ├── 2023_10_23_235000_maintenance_item.php
│   ├── 2023_10_25_003000_maintenance_maintenance_item_amount_gross.php
│   ├── 2023_10_31_185000_user_admin_mode.php
│   ├── 2023_10_31_185000_user_manager.php
│   ├── 2023_11_23_003000_user_timezone_id.php
│   ├── 2023_11_30_003000_refuel_position_id.php
│   ├── 2023_11_30_230000_city_country_id.php
│   ├── 2023_11_30_230000_position_state_country.php
│   ├── 2023_12_08_133000_language_default.php
│   ├── 2023_12_27_203000_point_latitude_longitude.php
│   ├── 2024_01_04_193000_refuel_point.php
│   ├── 2024_01_04_203000_city_only.php
│   ├── 2024_04_01_183000_language_rtl.php
│   ├── 2024_04_01_190000_user_api_key.php
│   ├── 2025_01_18_190000_language_code.php
│   ├── 2025_03_24_110000_position_point_invisible.php
│   ├── 2025_03_24_230000_alarm_notification_point_invisible.php
│   ├── 2025_03_24_230000_city_point_invisible.php
│   ├── 2025_03_24_230000_refuel_point_invisible.php
│   ├── 2025_03_24_230000_timezone_geojson_invisible.php
│   ├── 2025_03_24_233000_spatial_index.php
│   ├── 2025_07_09_200000_alarm_vehicle_state.php
│   ├── 2025_07_23_200000_alarm_dashboard.php
│   ├── 2025_07_24_010000_device_config.php
│   └── 2025_07_24_010000_vehicle_config.php
└── schema/
    └── mysql-schema.sql


Excluded Content:

Files:

- /database/.dockerignore

- /database/.gitignore

- /database/schema/mysql-schema.sql


`database/Seeders/Database.php:`

```php
<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Configuration\Seeder\Configuration as ConfigurationSeeder;
use App\Domains\Language\Seeder\Language as LanguageSeeder;
use App\Domains\Server\Seeder\Server as ServerSeeder;
use App\Domains\Timezone\Seeder\Timezone as TimezoneSeeder;

class Database extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $time = time();

        $this->call(ConfigurationSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(ServerSeeder::class);
        $this->call(TimezoneSeeder::class);

        $this->command->info(sprintf('Seeding: Total Time %s seconds', time() - $time));
    }
}

```


`database/migrations/2021_01_14_000000_base.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
        $this->unprepared();
        $this->keys();
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

            $table->boolean('dashboard')->default(0);
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

            $table->geometry('point', 'point', 4326)->invisible();

            $table->boolean('dashboard')->default(0);
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

            $table->boolean('state')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('alarm_id');
            $table->unsignedBigInteger('vehicle_id');
        });

        Schema::create('city', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->jsonb('alias')->nullable();

            $table->geometry('point', 'point', 4326)->invisible();

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

            $table->jsonb('config')->nullable();

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
            $table->string('locale')->unique();

            $table->boolean('rtl')->default(0);
            $table->boolean('enabled')->default(0);

            $this->timestamps($table);
        });

        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('workshop')->default('');

            $table->text('description');

            $table->date('date_at');

            $table->decimal('amount', 10, 2)->default(0);

            $table->decimal('distance', 10, 2)->default(0);
            $table->decimal('distance_next', 10, 2)->default(0);

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

            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('amount_gross', 10, 2)->default(0);
            $table->decimal('amount_net', 10, 2)->default(0);
            $table->decimal('tax_percent', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('maintenance_id');
            $table->unsignedBigInteger('maintenance_item_id');
        });

        Schema::create('position', function (Blueprint $table) {
            $table->id();

            $table->geometry('point', 'point', 4326)->invisible();

            $table->decimal('speed', 6, 2);

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

            $table->decimal('distance_total', 10, 2);
            $table->decimal('distance', 6, 2);
            $table->decimal('quantity', 6, 2);
            $table->decimal('quantity_before', 6, 2);
            $table->decimal('price', 7, 3);
            $table->decimal('total', 6, 2);

            $table->geometry('point', 'point', 4326)->invisible();

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
            $table->geometry('geojson', 'multipolygon')->invisible();

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

            $table->string('api_key')->nullable()->index()->unique();
            $table->string('api_key_prefix')->nullable();
            $table->boolean('api_key_enabled')->default(0);

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

            $table->jsonb('config')->nullable();

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
            $this->tableAddUnique($table, ['alarm_id', 'vehicle_id']);

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

```


`database/migrations/2021_01_14_000001_seed.php:`

```php
<?php declare(strict_types=1);

use App\Domains\Configuration\Seeder\Configuration as ConfigurationSeeder;
use App\Domains\Language\Seeder\Language as LanguageSeeder;
use App\Domains\Server\Seeder\Server as ServerSeeder;
use App\Domains\CoreApp\Migration\MigrationAbstract;
use App\Domains\Timezone\Seeder\Timezone as TimezoneSeeder;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->seed();
    }

    /**
     * @return void
     */
    protected function seed(): void
    {
        (new ConfigurationSeeder())->run();
        (new LanguageSeeder())->run();
        (new ServerSeeder())->run();
        (new TimezoneSeeder())->run();
    }
};

```


`database/migrations/2022_10_04_184500_device_password_port.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'password');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->string('password')->default('');
            $table->unsignedInteger('port')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropColumn('port');
        });
    }
};

```


`database/migrations/2022_10_06_183000_trip_distance_time.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('trip', 'distance');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->unsignedInteger('distance')->default(0);
            $table->unsignedInteger('time')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('distance');
            $table->dropColumn('time');
        });
    }
};

```


`database/migrations/2022_10_06_183000_trip_sleep.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('trip', 'sleep') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('sleep');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->boolean('sleep')->default(0);
        });
    }
};

```


`database/migrations/2022_10_07_190000_city_state_country.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('city');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::create('city', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->jsonb('alias')->nullable();

            $table->geometry('point', 'point', 4326);

            $this->timestamps($table);

            $table->unsignedBigInteger('state_id');
        });

        Schema::create('country', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name')->index();
            $table->jsonb('alias')->nullable();

            $this->timestamps($table);
        });

        Schema::create('state', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->jsonb('alias')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('country_id');
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'state');
        });

        Schema::table('state', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'country');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::drop('city');
        Schema::drop('state');
        Schema::drop('country');
    }
};

```


`database/migrations/2022_10_07_193000_position_city.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('position', 'city_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->nullable();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'city');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->dropForeign('position_city_fk');
            $table->dropColumn('city_id');
        });
    }
};

```


`database/migrations/2022_10_09_233000_device_timezone.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'timezone')
            || Schema::hasColumn('device', 'timezone_id')
            || Schema::hasTable('vehicle');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->string('timezone');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });
    }
};

```


`database/migrations/2022_10_10_153000_point_4326.php:`

```php
<?php declare(strict_types=1);

use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->db()->unprepared('ALTER TABLE `city` MODIFY COLUMN `point` POINT NOT NULL SRID 4326;');
        $this->db()->unprepared('ALTER TABLE `position` MODIFY COLUMN `point` POINT NOT NULL SRID 4326;');
    }
};

```


`database/migrations/2022_10_11_173000_user_admin.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user', 'admin');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->boolean('admin')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('admin');
        });
    }
};

```


`database/migrations/2022_10_16_190000_timezone.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;
use App\Domains\Timezone\Seeder\Timezone as TimezoneSeeder;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
        $this->seed();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('timezone');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::create('timezone', function (Blueprint $table) {
            $table->id();

            $table->string('zone')->index();
            $table->integer('offset');
            $table->string('gmt');
            $table->string('abbr');

            $this->timestamps($table);
        });
    }

    /**
     * @return void
     */
    protected function seed(): void
    {
        (new TimezoneSeeder())->run();
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::drop('timezone');
    }
};

```


`database/migrations/2022_10_16_193000_device_timezone.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'timezone_id')
            || Schema::hasTable('vehicle');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `device` SET `timezone_id` = (
                SELECT `timezone`.`id`
                FROM `timezone`
                WHERE `timezone`.`zone` = `device`.`timezone`
                LIMIT 1
            );
        ');

        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('timezone');
            $table->unsignedBigInteger('timezone_id')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->string('timezone')->index();
        });

        $this->db()->unprepared('
            UPDATE `device` SET `timezone` = (
                SELECT `timezone`.`zone`
                FROM `timezone`
                WHERE `timezone`.`id` = `device`.`timezone_id`
                LIMIT 1
            );
        ');

        Schema::table('device', function (Blueprint $table) {
            $table->dropForeign('device_timezone_fk');
            $table->dropColumn('timezone_id');
        });
    }
};

```


`database/migrations/2022_10_16_193000_position_date_utc_at.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('position', 'date_utc_at');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->dateTime('date_utc_at')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `position` SET `date_utc_at` = DATE_SUB(`date_at`, INTERVAL 2 HOUR);
        ');

        Schema::table('position', function (Blueprint $table) {
            $table->dateTime('date_utc_at')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->dropColumn('date_utc_at');
        });
    }
};

```


`database/migrations/2022_10_16_193000_position_timezone.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('position', 'timezone_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `position` SET `timezone_id` = (
                SELECT `device`.`timezone_id`
                FROM `device`
                WHERE `device`.`id` = `position`.`device_id`
                LIMIT 1
            );
        ');

        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->dropForeign('position_timezone_fk');
            $table->dropColumn('timezone_id');
        });
    }
};

```


`database/migrations/2022_10_17_193000_refuel_units.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('refuel', 'distance_total');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->renameColumn('kilometers', 'distance_total');
            $table->renameColumn('litres', 'quantity');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->renameColumn('distance_total', 'kilometers');
            $table->renameColumn('quantity', 'litres');
        });
    }
};

```


`database/migrations/2022_10_17_193000_trip_dates_utc_at.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('trip', 'start_utc_at');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dateTime('start_utc_at')->nullable();
            $table->dateTime('end_utc_at')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `trip` SET
                `start_utc_at` = DATE_SUB(`start_at`, INTERVAL 2 HOUR),
                `end_utc_at` = DATE_SUB(`end_at`, INTERVAL 2 HOUR);
        ');

        Schema::table('trip', function (Blueprint $table) {
            $table->dateTime('start_utc_at')->nullable(false)->change();
            $table->dateTime('end_utc_at')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('start_utc_at');
            $table->dropColumn('end_utc_at');
        });
    }
};

```


`database/migrations/2022_10_17_193000_trip_timezone.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('trip', 'timezone_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `trip` SET `timezone_id` = (
                SELECT `device`.`timezone_id`
                FROM `device`
                WHERE `device`.`id` = `trip`.`device_id`
                LIMIT 1
            );
        ');

        Schema::table('trip', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropForeign('trip_timezone_fk');
            $table->dropColumn('timezone_id');
        });
    }
};

```


`database/migrations/2022_10_17_230000_refuel_quantity_before.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('refuel', 'quantity_before');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->decimal('quantity_before', 6, 2);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->dropColumn('quantity_before');
        });
    }
};

```


`database/migrations/2022_10_17_233000_refuel_price.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->decimal('price', 7, 3)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->decimal('price', 6, 2)->change();
        });
    }
};

```


`database/migrations/2022_11_01_193000_device_timezone_auto.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'timezone_auto')
            || Schema::hasTable('vehicle');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->boolean('timezone_auto')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('timezone_auto');
        });
    }
};

```


`database/migrations/2022_11_02_180000_timezone_unused.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('timezone', 'offset') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->dropColumn('offset');
            $table->dropColumn('gmt');
            $table->dropColumn('abbr');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->integer('offset');
            $table->string('gmt');
            $table->string('abbr');
        });
    }
};

```


`database/migrations/2022_11_02_183000_timezone_geojson.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('timezone', 'geojson');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->geometry('geojson', 'multipolygon')->nullable();
        });

        $this->db()->unprepared('UPDATE `timezone` SET `geojson` = '.TimezoneModel::emptyGeoJSON().';');
        $this->db()->unprepared('ALTER TABLE `timezone` MODIFY COLUMN `geojson` multipolygon NOT NULL;');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->spatialIndex('geojson');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->dropColumn('geojson');
        });
    }
};

```


`database/migrations/2022_11_04_183000_device_connected_at.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'connected_at');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dateTimeTz('connected_at')->nullable();
        });

        $this->db()->unprepared('UPDATE `device` SET `connected_at` = (
            SELECT MAX(`position`.`date_utc_at`)
            FROM `position`
            WHERE `position`.`device_id` = `device`.`id`
        );');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('connected_at');
        });
    }
};

```


`database/migrations/2022_11_05_220000_position_trip_id.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->db()->unprepared('DELETE FROM `position` WHERE `trip_id` IS NULL;');

        Schema::table('position', function (Blueprint $table) {
            $this->tableDropForeign($table, 'trip', 'fk');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('trip_id')->nullable(false)->change();
        });

        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'trip');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $this->tableDropForeign($table, 'trip', 'fk');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('trip_id')->nullable(true)->change();
        });

        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'trip');
        });
    }
};

```


`database/migrations/2022_11_07_183000_device_message.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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

```


`database/migrations/2022_11_08_190000_device_message_response.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device_message', function (Blueprint $table) {
            $table->text('response')->nullable()->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device_message', function (Blueprint $table) {
            $table->string('response')->nullable()->change();
        });
    }
};

```


`database/migrations/2022_11_09_183000_device_phone_number.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'phone_number');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('phone_number');
        });
    }
};

```


`database/migrations/2022_11_10_183000_device_alarm.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
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

```


`database/migrations/2022_11_23_220000_device_alarm_keys.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('device_alarm') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->db()->unprepared('
            DELETE FROM `device_alarm`
            WHERE `device_id` NOT IN (
                SELECT `id`
                FROM `device`
            );
        ');

        $this->db()->unprepared('
            DELETE FROM `device_alarm_notification`
            WHERE `device_id` NOT IN (
                SELECT `id`
                FROM `device`
            );
        ');

        $this->db()->unprepared('
            DELETE FROM `device_alarm_notification`
            WHERE `device_alarm_id` NOT IN (
                SELECT `id`
                FROM `device_alarm`
            );
        ');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
            $this->foreignOnDeleteCascade($table, 'device_alarm');
            $this->foreignOnDeleteSetNull($table, 'position');
            $this->foreignOnDeleteSetNull($table, 'trip');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');
            $this->tableDropForeign($table, 'device_alarm', 'fk_');
            $this->tableDropForeign($table, 'position', 'fk_');
            $this->tableDropForeign($table, 'trip', 'fk_');
        });
    }
};

```


`database/migrations/2022_11_23_233000_user_telegram.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user', 'telegram');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->jsonb('telegram')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('telegram');
        });
    }
};

```


`database/migrations/2022_11_24_183000_device_alarm_telegram.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return (Schema::hasTable('device_alarm') === false)
            || Schema::hasColumn('device_alarm', 'telegram');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $table->boolean('telegram')->default(0);
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $table->boolean('telegram')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $table->dropColumn('telegram');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $table->dropColumn('telegram');
        });
    }
};

```


`database/migrations/2022_11_24_220000_device_alarm_notification_foreign.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->keys();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('device_alarm_notification') === false;
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device_alarm', 'fk_');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $table->unsignedBigInteger('device_alarm_id')->nullable(true)->change();
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'device_alarm');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device_alarm', 'fk_');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $table->unsignedBigInteger('device_alarm_id')->nullable(false)->change();
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device_alarm');
        });
    }
};

```


`database/migrations/2022_11_25_223000_device_alarm_rename.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('alarm');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');
            $this->tableDropIndex($table, 'device', 'fk_');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');
            $this->tableDropForeign($table, 'device_alarm', 'fk_');
            $this->tableDropForeign($table, 'position', 'fk_');
            $this->tableDropForeign($table, 'trip', 'fk_');

            $this->tableDropIndex($table, 'device', 'fk_');
            $this->tableDropIndex($table, 'device_alarm', 'fk_');
            $this->tableDropIndex($table, 'position', 'fk_');
            $this->tableDropIndex($table, 'trip', 'fk_');
        });

        Schema::rename('device_alarm', 'alarm');
        Schema::rename('device_alarm_notification', 'alarm_notification');

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->renameColumn('device_alarm_id', 'alarm_id');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'alarm');
            $this->foreignOnDeleteCascade($table, 'device');
            $this->foreignOnDeleteSetNull($table, 'position');
            $this->foreignOnDeleteSetNull($table, 'trip');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->tableDropForeign($table, 'alarm', 'fk_');
            $this->tableDropForeign($table, 'device', 'fk_');
            $this->tableDropForeign($table, 'position', 'fk_');
            $this->tableDropForeign($table, 'trip', 'fk_');

            $this->tableDropIndex($table, 'alarm', 'fk_');
            $this->tableDropIndex($table, 'device', 'fk_');
            $this->tableDropIndex($table, 'position', 'fk_');
            $this->tableDropIndex($table, 'trip', 'fk_');
        });

        Schema::rename('alarm', 'device_alarm');
        Schema::rename('alarm_notification', 'device_alarm_notification');

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $table->renameColumn('alarm_id', 'device_alarm_id');
        });

        Schema::table('device_alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
            $this->foreignOnDeleteSetNull($table, 'device_alarm');
            $this->foreignOnDeleteSetNull($table, 'position');
            $this->foreignOnDeleteSetNull($table, 'trip');
        });
    }
};

```


`database/migrations/2022_11_25_224000_device_alarm_multiple.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('alarm_vehicle')
            || Schema::hasTable('alarm_device');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `alarm`
            SET `user_id` = (
                SELECT `user_id`
                FROM `device`
                WHERE `device`.`id` = `alarm`.`device_id`
                LIMIT 1
            );
        ');

        Schema::create('alarm_device', function (Blueprint $table) {
            $table->id();

            $this->timestamps($table);

            $table->unsignedBigInteger('alarm_id');
            $table->unsignedBigInteger('device_id');
        });

        $this->db()->unprepared('
            INSERT INTO `alarm_device`
            (`alarm_id`, `device_id`)
            (
                SELECT `alarm`.`id`, `device`.`id`
                FROM `alarm`, `device`
            );
        ');

        Schema::table('alarm', function (Blueprint $table) {
            $this->tableDropForeign($table, 'device', 'fk_');

            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });

        Schema::table('alarm', function (Blueprint $table) {
            $table->dropColumn('device_id');
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('alarm_device', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'alarm');
            $this->foreignOnDeleteCascade($table, 'device');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->unsignedBigInteger('device_id')->nullable();

            $this->tableDropForeign($table, 'user', 'fk_');
        });

        $this->db()->unprepared('
            UPDATE `alarm`
            SET `device_id` = (
                SELECT `alarm_device`.`device_id`
                FROM `alarm_device`
                WHERE `alarm_device`.`alarm_id` = `alarm`.`id`
                LIMIT 1
            );
        ');

        Schema::table('alarm', function (Blueprint $table) {
            $table->unsignedBigInteger('device_id')->nullable(false)->change();

            $table->dropColumn('user_id');
        });

        Schema::table('alarm', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'device');
        });

        Schema::drop('alarm_device');
    }
};

```


`database/migrations/2022_11_27_190000_timezone_default.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('timezone', 'default');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->boolean('default')->default(0);
        });

        $this->db()->unprepared('
            UPDATE `timezone`
            SET `default` = true
            WHERE `zone` = (
                SELECT `value`
                FROM `configuration`
                WHERE `key` = "timezone_default"
                LIMIT 1
            );
        ');

        $this->db()->unprepared('
            DELETE FROM `configuration`
            WHERE `key` = "timezone_default";
        ');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->dropColumn('default');
        });

        $this->db()->unprepared('
            INSERT INTO `configuration`
            SET
                `key` = "timezone_default",
                `value` = "Europe/Madrid",
                `description` = "Zona Horaria por defecto de la Plataforma";
        ');
    }
};

```


`database/migrations/2022_11_27_220000_alarm_notification_date_at.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('alarm_notification', 'date_at');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dateTime('date_at')->nullable();
            $table->dateTime('date_utc_at')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `alarm_notification`
            JOIN `device` ON (`device`.`id` = `alarm_notification`.`device_id`)
            JOIN `timezone` ON (`timezone`.`id` = `device`.`timezone_id`)
            SET
                `alarm_notification`.`date_utc_at` = `alarm_notification`.`created_at`,
                `alarm_notification`.`date_at` = CONVERT_TZ(`alarm_notification`.`created_at`, "UTC", `timezone`.`zone`);
        ');

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dateTime('date_at')->nullable(false)->change();
            $table->dateTime('date_utc_at')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dropColumn('date_at');
            $table->dropColumn('date_utc_at');
        });
    }
};

```


`database/migrations/2022_11_27_223000_alarm_notification_point.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('alarm_notification', 'point');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->nullable();
        });

        $this->db()->unprepared('
            UPDATE `alarm_notification`
            JOIN `position` ON (`position`.`id` = `alarm_notification`.`position_id`)
            SET `alarm_notification`.`point` = `position`.`point`;
        ');

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dropColumn('point');
        });
    }
};

```


`database/migrations/2022_12_02_183000_server.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
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
    protected function tables(): void
    {
        Schema::create('server', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('port')->default(0);
            $table->string('protocol');

            $table->boolean('enabled')->default(0);

            $this->timestamps($table);
        });

        $this->db()->unprepared('
            INSERT INTO `server`
            SET `port` = 8091, `protocol` = "h02", `enabled` = true;
        ');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::drop('server');
    }
};

```


`database/migrations/2022_12_20_183000_vehicle.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
        $this->migrate();
        $this->tablesFinish();
        $this->keys();
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

```


`database/migrations/2022_12_22_223000_configuration_socket_debug.php:`

```php
<?php declare(strict_types=1);

use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->db()->unprepared('
            DELETE FROM `configuration`
            WHERE `key` = "socket_debug"
            LIMIT 1;
        ');
    }
};

```


`database/migrations/2022_12_22_223000_device_port.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'port') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('port');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->unsignedInteger('port')->default(0);
        });
    }
};

```


`database/migrations/2022_12_27_183000_server_debug.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
        $this->delete();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('server', 'debug');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('server', function (Blueprint $table) {
            $table->boolean('debug')->default(0);
        });
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->db()->unprepared('
            DELETE FROM `configuration`
            WHERE `key` = "server_debug"
            LIMIT 1;
        ');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('server', function (Blueprint $table) {
            $table->dropColumn('debug');
        });
    }
};

```


`database/migrations/2022_12_29_220000_trip_stats.php:`

```php
<?php declare(strict_types=1);

use App\Domains\Core\Traits\Factory;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    use Factory;

    /**
     * @return void
     */
    public function up(): void
    {
        $this->factory('Trip')->action()->updateStatsAll();
    }
};

```


`database/migrations/2023_01_02_230000_user_preferences.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user', 'preferences');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->jsonb('preferences')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('preferences');
        });
    }
};

```


`database/migrations/2023_02_01_230000_trip_shared.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('trip', 'shared');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->string('code')->index()->nullable();
            $table->boolean('shared')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('shared');
        });
    }
};

```


`database/migrations/2023_02_07_234500_device_timezone_auto.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'timezone_auto') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('timezone_auto');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->boolean('timezone_auto')->default(0);
        });
    }
};

```


`database/migrations/2023_03_09_163000_alarm_schedule.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('alarm', 'schedule_start');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->string('schedule_start')->nullable();
            $table->string('schedule_end')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->dropColumn('schedule_start');
            $table->dropColumn('schedule_end');
        });
    }
};

```


`database/migrations/2023_03_22_183000_ip_lock_index.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('ip_lock', function (Blueprint $table) {
            $this->tableAddIndex($table, 'ip');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('ip_lock', function (Blueprint $table) {
            $this->tableAddIndex($table, 'ip');
        });
    }
};

```


`database/migrations/2023_04_27_203000_position_point_swap.php:`

```php
<?php declare(strict_types=1);

use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->update();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        try {
            $result = $this->db()->select($this->upMigratedQuery());
        } catch (Exception $e) {
            return false;
        }

        return empty($result)
            || $result[0]->migrated;
    }

    /**
     * @return string
     */
    protected function upMigratedQuery(): string
    {
        return '
            SELECT ST_Y(`point`) = ST_Longitude(`point`) AS `migrated`
            FROM `position`
            ORDER BY `id` ASC
            LIMIT 1;
        ';
    }

    /**
     * @return void
     */
    protected function update(): void
    {
        $this->updateAlarmNotification();
        $this->updateCity();
        $this->updatePosition();
    }

    /**
     * @return void
     */
    protected function updateAlarmNotification(): void
    {
        $this->db()->unprepared('
            DELETE FROM `alarm_notification`
            WHERE ST_Y(`point`) > 90;
        ');

        $this->db()->unprepared('
            UPDATE `alarm_notification`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function updateCity(): void
    {
        $this->db()->unprepared('
            DELETE FROM `city`
            WHERE ST_Y(`point`) > 90;
        ');

        $this->db()->unprepared('
            UPDATE `city`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function updatePosition(): void
    {
        $this->db()->unprepared('
            DELETE FROM `position`
            WHERE ST_Y(`point`) > 90;
        ');

        $this->db()->unprepared('
            DELETE FROM `trip`
            WHERE NOT EXISTS (
                SELECT *
                FROM `position`
                WHERE `position`.`trip_id` = `trip`.`id`
            );
        ');

        $this->db()->unprepared('
            UPDATE `position`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->downAlarmNotification();
        $this->downCity();
        $this->downPosition();
    }

    /**
     * @return void
     */
    protected function downAlarmNotification(): void
    {
        $this->db()->unprepared('
            DELETE FROM `alarm_notification`
            WHERE ST_X(`point`) > 90;
        ');

        $this->db()->unprepared('
            UPDATE `alarm_notification`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function downCity(): void
    {
        $this->db()->unprepared('
            DELETE FROM `city`
            WHERE ST_X(`point`) > 90;
        ');

        $this->db()->unprepared('
            UPDATE `city`
            SET `point` = ST_SwapXY(`point`);
        ');
    }

    /**
     * @return void
     */
    protected function downPosition(): void
    {
        $this->db()->unprepared('
            DELETE FROM `position`
            WHERE ST_X(`point`) > 90;
        ');

        $this->db()->unprepared('
            UPDATE `position`
            SET `point` = ST_SwapXY(`point`);
        ');
    }
};

```


`database/migrations/2023_09_13_223000_maintenance.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('maintenance');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('workshop')->default('');

            $table->text('description');

            $table->dateTime('date_at');

            $table->decimal('amount', 10, 2)->default(0);

            $table->decimal('distance', 10, 2)->default(0);
            $table->decimal('distance_next', 10, 2)->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vehicle_id');
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('maintenance', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
            $this->foreignOnDeleteCascade($table, 'vehicle');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::drop('maintenance');
    }
};

```


`database/migrations/2023_09_14_190000_file.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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

```


`database/migrations/2023_09_15_183000_maintenance_date_at.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('maintenance', function (Blueprint $table) {
            $table->date('date_at')->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('maintenance', function (Blueprint $table) {
            $table->dateTime('date_at')->change();
        });
    }
};

```


`database/migrations/2023_09_25_200000_device_shared.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'shared');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->string('code')->index()->nullable();
            $table->boolean('shared')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('shared');
        });
    }
};

```


`database/migrations/2023_09_27_004500_device_maker_model.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'model');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->renameColumn('maker', 'model');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->renameColumn('model', 'maker');
        });
    }
};

```


`database/migrations/2023_09_27_005000_device_trip_shared_public.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'shared_public');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->boolean('shared_public')->default(0);
        });

        Schema::table('trip', function (Blueprint $table) {
            $table->boolean('shared_public')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('shared_public');
        });

        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('shared_public');
        });
    }
};

```


`database/migrations/2023_09_27_185000_device_trip_code_uuid.php:`

```php
<?php declare(strict_types=1);

use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->update();
    }

    /**
     * @return void
     */
    protected function update(): void
    {
        $this->db()->unprepared('
            UPDATE `trip`
            SET `code` = (SELECT UUID())
            WHERE `code` IS NULL;
        ');

        $this->db()->unprepared('
            UPDATE `device`
            SET `code` = (SELECT UUID())
            WHERE `code` IS NULL;
        ');
    }
};

```


`database/migrations/2023_09_29_185000_position_index.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $this->tableAddIndex($table, ['device_id', 'date_utc_at']);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $this->tableDropIndex($table, ['device_id', 'date_utc_at']);
        });
    }
};

```


`database/migrations/2023_10_02_185000_position_index.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $this->tableAddIndex($table, ['trip_id', 'date_utc_at']);
            $this->tableAddIndex($table, ['user_id', 'date_utc_at']);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $this->tableDropIndex($table, ['trip_id', 'date_utc_at']);
            $this->tableDropIndex($table, ['user_id', 'date_utc_at']);
        });
    }
};

```


`database/migrations/2023_10_05_185000_user_fail.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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

```


`database/migrations/2023_10_05_190000_user_session_to_user_fail.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user_session', 'success') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->db()->unprepared('
            INSERT INTO `user_fail` (`type`, `text`, `ip`, `created_at`, `updated_at`, `user_id`)
            (
                SELECT "user-auth-credentials", `auth`, `ip`, `created_at`, `updated_at`, `user_id`
                FROM `user_session`
                WHERE `success` = FALSE
            );
        ');

        $this->db()->unprepared('
            DELETE FROM `user_session`
            WHERE (
                `success` = FALSE
                OR `user_id` IS NULL
            );
        ');

        Schema::table('user_session', function (Blueprint $table) {
            $table->dropColumn('success');
            $table->dropForeign('user_session_user_fk');
        });

        Schema::table('user_session', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('user_session', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('user_session', function (Blueprint $table) {
            $table->boolean('success')->default(0);
            $table->dropForeign('user_session_user_fk');

            $table->unsignedBigInteger('user_id')->nullable()->change();
        });

        Schema::table('user_session', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'user');
        });
    }
};

```


`database/migrations/2023_10_05_235000_trip_index.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->keys();
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $this->tableAddIndex($table, ['shared_public', 'shared', 'device_id', 'end_utc_at']);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('trip', function (Blueprint $table) {
            $this->tableDropIndex($table, ['shared_public', 'shared', 'device_id', 'end_utc_at']);
        });
    }
};

```


`database/migrations/2023_10_23_235000_maintenance_item.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('maintenance_item');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::create('maintenance_item', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id');
        });

        Schema::create('maintenance_maintenance_item', function (Blueprint $table) {
            $table->id();

            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('tax_percent', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('maintenance_id');
            $table->unsignedBigInteger('maintenance_item_id');
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('maintenance_item', function (Blueprint $table) {
            $this->tableAddUnique($table, ['name', 'user_id']);

            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('maintenance_maintenance_item', function (Blueprint $table) {
            $this->tableAddUnique($table, ['maintenance_id', 'maintenance_item_id']);

            $this->foreignOnDeleteCascade($table, 'maintenance');
            $this->foreignOnDeleteCascade($table, 'maintenance_item');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_maintenance_item');
        Schema::dropIfExists('maintenance_item');
    }
};

```


`database/migrations/2023_10_25_003000_maintenance_maintenance_item_amount_gross.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
        $this->update();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('maintenance_maintenance_item', 'amount_gross');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('maintenance_maintenance_item', function (Blueprint $table) {
            $table->renameColumn('amount', 'amount_gross');
            $table->decimal('amount_net', 10, 2)->default(0);
        });
    }

    /**
     * @return void
     */
    protected function update(): void
    {
        $this->db()->unprepared('
            UPDATE `maintenance_maintenance_item`
            SET `amount_net` = `amount_gross` * (1 + `tax_percent` / 100);
        ');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('maintenance_maintenance_item', function (Blueprint $table) {
            $table->renameColumn('amount_gross', 'amount');
            $table->dropColumn('amount_net');
        });
    }
};

```


`database/migrations/2023_10_31_185000_user_admin_mode.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user', 'admin_mode');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->boolean('admin_mode')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('admin_mode');
        });
    }
};

```


`database/migrations/2023_10_31_185000_user_manager.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user', 'manager');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->boolean('manager')->default(0);
            $table->boolean('manager_mode')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('manager');
            $table->dropColumn('manager_mode');
        });
    }
};

```


`database/migrations/2023_11_23_003000_user_timezone_id.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user', 'timezone_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `user` SET `timezone_id` = (
                SELECT `id`
                FROM `timezone`
                WHERE `default` = true
                LIMIT 1
            );
        ');

        Schema::table('user', function (Blueprint $table) {
            $table->unsignedBigInteger('timezone_id')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'timezone');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropForeign('user_timezone_fk');
            $table->dropColumn('timezone_id');
        });
    }
};

```


`database/migrations/2023_11_30_003000_refuel_position_id.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('refuel', 'position_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `refuel` SET `position_id` = (
                SELECT `position`.`id`
                FROM `position`
                WHERE (
                    `position`.`date_at` <= `refuel`.`date_at`
                    AND `position`.`user_id` = `refuel`.`user_id`
                )
                ORDER BY `position`.`date_at` DESC
                LIMIT 1
            );
        ');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'position');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->dropForeign('refuel_position_fk');
            $table->dropColumn('position_id');
        });
    }
};

```


`database/migrations/2023_11_30_230000_city_country_id.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('city', 'country_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `city`
            SET `country_id` = (
                SELECT `state`.`country_id`
                FROM `state`
                WHERE `state`.`id` = `city`.`state_id`
            );
        ');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'country');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $table->dropForeign('city_country_fk');
            $table->dropColumn('country_id');
        });
    }
};

```


`database/migrations/2023_11_30_230000_position_state_country.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('position', 'country_id');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
        });

        $this->db()->unprepared('
            UPDATE `position`
            JOIN `city` ON (`city`.`id` = `position`.`city_id`)
            SET
                `position`.`state_id` = `city`.`state_id`,
                `position`.`country_id` = `city`.`country_id`
            WHERE `position`.`city_id` IS NOT NULL;
        ');
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'country');
            $this->foreignOnDeleteSetNull($table, 'state');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->dropForeign('position_country_fk');
            $table->dropForeign('position_state_fk');

            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
        });
    }
};

```


`database/migrations/2023_12_08_133000_language_default.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('language', 'default') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->dropColumn('default');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->boolean('default')->default(0);
        });

        $this->db()->unprepared('
            UPDATE `language`
            SET `default` = TRUE
            LIMIT 1;
        ');
    }
};

```


`database/migrations/2023_12_27_203000_point_latitude_longitude.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('position', 'latitude');
    }

    /**
     * @return void
     */
    protected function tables(): void
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
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->tableAddIndex($table, 'latitude');
            $this->tableAddIndex($table, 'longitude');
        });

        Schema::table('city', function (Blueprint $table) {
            $this->tableAddIndex($table, 'latitude');
            $this->tableAddIndex($table, 'longitude');
        });

        Schema::table('position', function (Blueprint $table) {
            $this->tableAddIndex($table, 'latitude');
            $this->tableAddIndex($table, 'longitude');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });

        Schema::table('city', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
};

```


`database/migrations/2024_01_04_193000_refuel_point.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
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
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('refuel', 'point');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->nullable();

            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
        });

        $this->db()->unprepared('
            ALTER TABLE `refuel`
            ADD COLUMN `latitude` DOUBLE AS (ROUND(ST_LATITUDE(`point`), 5)) STORED,
            ADD COLUMN `longitude` DOUBLE AS (ROUND(ST_LONGITUDE(`point`), 5)) STORED;
        ');

        $this->db()->unprepared('
            UPDATE `refuel`
            SET `position_id` = (
                SELECT `position`.`id`
                FROM `position`
                ORDER BY ABS(TIMESTAMPDIFF(SECOND, `refuel`.`date_at`, `position`.`date_at`))
                LIMIT 1
            )
            WHERE `position_id` IS NULL;
        ');

        $this->db()->unprepared('
            UPDATE `refuel`
            JOIN `position` ON (`position`.`id` = `refuel`.`position_id`)
            SET
                `refuel`.`point` = `position`.`point`,
                `refuel`.`city_id` = `position`.`city_id`,
                `refuel`.`state_id` = `position`.`state_id`,
                `refuel`.`country_id` = `position`.`country_id`;
        ');

        Schema::table('refuel', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->nullable(false)->index()->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'city');
            $this->foreignOnDeleteSetNull($table, 'country');
            $this->foreignOnDeleteSetNull($table, 'state');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->dropForeign('refuel_city_fk');
            $table->dropForeign('refuel_country_fk');
            $table->dropForeign('refuel_state_fk');

            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('point');

            $table->dropColumn('city_id');
            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
        });
    }
};

```


`database/migrations/2024_01_04_203000_city_only.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->tables();
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->tablesPosition();
        $this->tablesRefuel();
    }

    /**
     * @return void
     */
    protected function tablesPosition(): void
    {
        if (Schema::hasColumn('position', 'state_id') === false) {
            return;
        }

        Schema::table('position', function (Blueprint $table) {
            $table->dropForeign('position_country_fk');
            $table->dropForeign('position_state_fk');

            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
        });
    }

    /**
     * @return void
     */
    protected function tablesRefuel(): void
    {
        if (Schema::hasColumn('refuel', 'state_id') === false) {
            return;
        }

        Schema::table('refuel', function (Blueprint $table) {
            $table->dropForeign('refuel_country_fk');
            $table->dropForeign('refuel_state_fk');

            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->downPosition();
        $this->downRefuel();
    }

    /**
     * @return void
     */
    protected function downPosition(): void
    {
        if (Schema::hasColumn('position', 'state_id')) {
            return;
        }

        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
        });

        Schema::table('position', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'country');
            $this->foreignOnDeleteSetNull($table, 'state');
        });

        $this->db()->unprepared('
            UPDATE `position`
            JOIN `city` ON (`city`.`id` = `position`.`city_id`)
            SET
                `position`.`state_id` = `city`.`state_id`,
                `position`.`country_id` = `city`.`country_id`;
        ');
    }

    /**
     * @return void
     */
    protected function downRefuel(): void
    {
        if (Schema::hasColumn('refuel', 'state_id')) {
            return;
        }

        Schema::table('refuel', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
        });

        Schema::table('refuel', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'country');
            $this->foreignOnDeleteSetNull($table, 'state');
        });

        $this->db()->unprepared('
            UPDATE `refuel`
            JOIN `city` ON (`city`.`id` = `refuel`.`city_id`)
            SET
                `refuel`.`state_id` = `city`.`state_id`,
                `refuel`.`country_id` = `city`.`country_id`;
        ');
    }
};

```


`database/migrations/2024_04_01_183000_language_rtl.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('language', 'rtl');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->boolean('rtl')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->dropColumn('rtl');
        });
    }
};

```


`database/migrations/2024_04_01_190000_user_api_key.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->upTables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user', 'api_key');
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('api_key')->nullable()->index()->unique();
            $table->string('api_key_prefix')->nullable();
            $table->boolean('api_key_enabled')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('api_key');
            $table->dropColumn('api_key_prefix');
            $table->dropColumn('api_key_enabled');
        });
    }
};

```


`database/migrations/2025_01_18_190000_language_code.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->upTables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('language', 'code') === false;
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->string('code')->unique();
        });
    }
};

```


`database/migrations/2025_03_24_110000_position_point_invisible.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->upTables();
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->invisible(true)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('position', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->invisible(false)->change();
        });
    }
};

```


`database/migrations/2025_03_24_230000_alarm_notification_point_invisible.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->upTables();
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->invisible(true)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->invisible(false)->change();
        });
    }
};

```


`database/migrations/2025_03_24_230000_city_point_invisible.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->upTables();
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('city', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->invisible(true)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->invisible(false)->change();
        });
    }
};

```


`database/migrations/2025_03_24_230000_refuel_point_invisible.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->upTables();
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('refuel', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->invisible(true)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('refuel', function (Blueprint $table) {
            $table->geometry('point', 'point', 4326)->invisible(false)->change();
        });
    }
};

```


`database/migrations/2025_03_24_230000_timezone_geojson_invisible.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->upTables();
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $this->tableDropIndex($table, 'geojson');
            $this->tableDropIndex($table, 'geojson', 'spatialindex');
        });

        Schema::table('timezone', function (Blueprint $table) {
            $table->geometry('geojson', 'multipolygon')->invisible(true)->change();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('timezone', function (Blueprint $table) {
            $table->geometry('geojson', 'multipolygon')->invisible(false)->change();
        });
    }
};

```


`database/migrations/2025_03_24_233000_spatial_index.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->upTables();
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('alarm_notification', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->spatialIndex('point');
        });

        Schema::table('city', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('city', function (Blueprint $table) {
            $table->spatialIndex('point');
        });

        Schema::table('position', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('position', function (Blueprint $table) {
            $table->spatialIndex('point');
        });

        Schema::table('refuel', function (Blueprint $table) {
            $this->tableDropIndex($table, 'point');
            $this->tableDropIndex($table, 'point', 'spatialindex');
        });

        Schema::table('refuel', function (Blueprint $table) {
            $table->spatialIndex('point');
        });

        Schema::table('timezone', function (Blueprint $table) {
            $this->tableDropIndex($table, 'geojson');
            $this->tableDropIndex($table, 'geojson', 'spatialindex');
        });

        Schema::table('timezone', function (Blueprint $table) {
            $table->spatialIndex('geojson');
        });
    }
};

```


`database/migrations/2025_07_09_200000_alarm_vehicle_state.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->upTables();
        $this->upKeys();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('alarm_vehicle', 'state');
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $table->boolean('state')->default(0);
        });
    }

    /**
     * @return void
     */
    protected function upKeys(): void
    {
        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $this->tableAddUnique($table, ['alarm_id', 'vehicle_id']);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $table->dropColumn('state');
        });

        Schema::table('alarm_vehicle', function (Blueprint $table) {
            $this->tableDropIndex($table, ['alarm_id', 'vehicle_id']);
        });
    }
};

```


`database/migrations/2025_07_23_200000_alarm_dashboard.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->upTables();
        $this->upUpdate();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('alarm', 'dashboard');
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->boolean('dashboard')->default(0);
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->boolean('dashboard')->default(0);
        });
    }

    /**
     * @return void
     */
    protected function upUpdate(): void
    {
        $this->db()->unprepared('UPDATE `alarm` SET `dashboard` = true;');
        $this->db()->unprepared('UPDATE `alarm_notification` SET `dashboard` = true;');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('alarm', function (Blueprint $table) {
            $table->dropColumn('dashboard');
        });

        Schema::table('alarm_notification', function (Blueprint $table) {
            $table->dropColumn('dashboard');
        });
    }
};

```


`database/migrations/2025_07_24_010000_device_config.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->upTables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device', 'config');
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->jsonb('config')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('config');
        });
    }
};

```


`database/migrations/2025_07_24_010000_vehicle_config.php:`

```php
<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->upTables();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('vehicle', 'config');
    }

    /**
     * @return void
     */
    protected function upTables(): void
    {
        Schema::table('vehicle', function (Blueprint $table) {
            $table->jsonb('config')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('vehicle', function (Blueprint $table) {
            $table->dropColumn('config');
        });
    }
};

```



