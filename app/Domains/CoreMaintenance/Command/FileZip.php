<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Command;

class FileZip extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:maintenance:file:zip {--days=10} {--folder=storage/logs} {--extensions=log}';

    /**
     * @var string
     */
    protected $description = 'Compress files with {--extensions=log} on {--folder=storage/logs} older than {--days=10}';

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
        ])->fileZip();

        $this->info('END');
    }
}
