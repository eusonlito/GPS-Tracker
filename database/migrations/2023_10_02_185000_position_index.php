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
        $this->tables();
        $this->upFinish();
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
        $this->defineTypePoint();

        Schema::table('position', function (Blueprint $table) {
            $this->tableDropIndex($table, ['trip_id', 'date_utc_at']);
            $this->tableDropIndex($table, ['user_id', 'date_utc_at']);
        });
    }
};
