<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;
use App\Domains\Timezone\Seeder\Timezone as TimezoneSeeder;

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
