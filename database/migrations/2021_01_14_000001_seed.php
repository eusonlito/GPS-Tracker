<?php declare(strict_types=1);

use App\Domains\Configuration\Seeder\Configuration as ConfigurationSeeder;
use App\Domains\Language\Seeder\Language as LanguageSeeder;
use App\Domains\Server\Seeder\Server as ServerSeeder;
use App\Domains\CoreApp\Migration\MigrationAbstract;
use App\Domains\Timezone\Seeder\Timezone as TimezoneSeeder;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        $this->seed();
    }

    /**
     * @return void
     */
    protected function seed(): void
    {
        (new ConfigurationSeeder())->run();
        (new LanguageSeeder())->run();
        (new ServerSeeder())->run();
        (new TimezoneSeeder())->run();
    }
};
