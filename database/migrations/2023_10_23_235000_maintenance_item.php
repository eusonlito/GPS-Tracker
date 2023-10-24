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

            $table->unsignedDecimal('quantity', 10, 2)->default(0);
            $table->unsignedDecimal('amount', 10, 2)->default(0);
            $table->unsignedDecimal('tax_percent', 10, 2)->default(0);
            $table->unsignedDecimal('tax_amount', 10, 2)->default(0);
            $table->unsignedDecimal('subtotal', 10, 2)->default(0);
            $table->unsignedDecimal('total', 10, 2)->default(0);

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
