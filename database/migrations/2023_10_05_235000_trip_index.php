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
        $this->keys();
        $this->upFinish();
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
        $this->defineTypePoint();

        Schema::table('trip', function (Blueprint $table) {
            $this->tableDropIndex($table, ['shared_public', 'shared', 'device_id', 'end_utc_at']);
        });
    }
};
