<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Command;

class FileZip extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:maintenance:file:zip';

    /**
     * @var string
     */
    protected $description = 'Compress old files on folder storage/logs';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('START');

        $this->factory()->action()->fileZip();

        $this->info('END');
    }
}
