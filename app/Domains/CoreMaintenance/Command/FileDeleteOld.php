<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Command;

class FileDeleteOld extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:maintenance:file:delete:old';

    /**
     * @var string
     */
    protected $description = 'Delete old logs files files';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('START');

        $this->factory()->action()->fileDeleteOld();

        $this->info('END');
    }
}
