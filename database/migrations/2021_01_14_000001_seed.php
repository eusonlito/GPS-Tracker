<?php declare(strict_types=1);

use App\Domains\Configuration\Seeder\Configuration as ConfigurationSeeder;
use App\Domains\Language\Seeder\Language as LanguageSeeder;
use App\Domains\Shared\Migration\MigrationAbstract;
use App\Domains\Timezone\Seeder\Timezone as TimezoneSeeder;

return new class extends MigrationAbstract
{
    /**
     * @return void
     */
    public function up()
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
        (new TimezoneSeeder())->run();
    }
};
