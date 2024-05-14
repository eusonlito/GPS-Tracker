<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Command;

class DirectoryEmptyDelete extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:maintenance:directory:empty:delete';

    /**
     * @var string
     */
    protected $description = 'Delete empty storage/logs directories';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('START');

        $this->factory()->action()->directoryEmptyDelete();

        $this->info('END');
    }
}
