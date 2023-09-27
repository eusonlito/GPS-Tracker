<?php declare(strict_types=1);

use App\Domains\Core\Traits\Factory;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    use Factory;

    /**
     * @return void
     */
    public function up(): void
    {
        $this->factory('Trip')->action()->updateStatsAll();
    }
};
