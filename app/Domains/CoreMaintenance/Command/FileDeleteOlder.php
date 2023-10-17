<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Command;

class FileDeleteOlder extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:maintenance:file:delete:older {--days=10} {--folder=storage/logs} {--extensions=log,zip}';

    /**
     * @var string
     */
    protected $description = 'Delete files with {--extensions=log,zip} on {--folder=storage/logs} older than {--days=10}';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('START');

        $this->factory()->action([
            'days' => $this->checkOption('days'),
            'folder' => $this->checkOption('folder'),
            'extensions' => explode(',', $this->checkOption('extensions')),
        ])->fileDeleteOlder();

        $this->info('END');
    }
}
