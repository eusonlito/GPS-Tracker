<?php declare(strict_types=1);

use App\Domains\Shared\Traits\Factory;
use App\Domains\SharedApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    use Factory;

    /**
     * @return void
     */
    public function up()
    {
        $this->factory('Trip')->action()->updateStatsAll();
    }
};
