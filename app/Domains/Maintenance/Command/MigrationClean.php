<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Command;

class MigrationClean extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'maintenance:migration:clean';

    /**
     * @var string
     */
    protected $description = 'Clean "migrations" table if migration file not exists';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('START');

        $this->factory()->action()->migrationClean();

        $this->info('END');
    }
}
