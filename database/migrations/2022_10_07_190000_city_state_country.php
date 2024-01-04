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

            $table->point('point');

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
