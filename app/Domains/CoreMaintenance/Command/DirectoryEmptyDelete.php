<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Command;

class DirectoryEmptyDelete extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:maintenance:directory:empty:delete {--folder=storage/logs}';

    /**
     * @var string
     */
    protected $description = 'Delete empty directories on {--folder=storage/logs}';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('START');

        $this->checkOption('folder');
        $this->requestWithOptions();

        $this->factory()->action()->directoryEmptyDelete();

        $this->info('END');
    }
}
