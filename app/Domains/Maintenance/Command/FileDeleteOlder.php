<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Command;

class FileDeleteOlder extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'maintenance:file:delete:older {--days=10} {--folder=storage/logs} {--extensions=log,zip}';

    /**
     * @var string
     */
    protected $description = 'Delete files with {--extensions=log,zip} on {--folder=storage/logs} older than {--days=10}';

    /**
     * @return void
     */
    public function handle()
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
