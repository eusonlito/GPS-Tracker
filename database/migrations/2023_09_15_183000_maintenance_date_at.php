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
        $this->tables();
        $this->upFinish();
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
