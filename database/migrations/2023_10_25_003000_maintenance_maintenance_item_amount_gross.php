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
        $this->update();
        $this->upFinish();
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
            $table->unsignedDecimal('amount_net', 10, 2)->default(0);
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
