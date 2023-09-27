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
