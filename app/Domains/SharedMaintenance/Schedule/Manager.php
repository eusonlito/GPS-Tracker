<?php declare(strict_types=1);

namespace App\Domains\SharedMaintenance\Schedule;

use App\Domains\SharedMaintenance\Command\CurlCacheClean as CurlCacheCleanCommand;
use App\Domains\SharedMaintenance\Command\FileDeleteOlder as FileDeleteOlderCommand;
use App\Domains\SharedMaintenance\Command\FileZip as FileZipCommand;
use App\Domains\Shared\Schedule\ScheduleAbstract;

class Manager extends ScheduleAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->curlCacheClean();
        $this->fileDeleteOlder();
        $this->fileZip();
    }

    /**
     * @return void
     */
    protected function curlCacheClean(): void
    {
        $this->command(CurlCacheCleanCommand::class, 'shared-maintenance-curl-cache-clean')->dailyAt('01:10');
    }

    /**
     * @return void
     */
    protected function fileDeleteOlder(): void
    {
        $this->command(FileDeleteOlderCommand::class, 'shared-maintenance-file-delete-older', [
            '--days' => 60,
            '--folder' => 'storage/logs',
            '--extensions' => ['json', 'log', 'zip'],
        ])->dailyAt('01:15');
    }

    /**
     * @return void
     */
    protected function fileZip(): void
    {
        $this->command(FileZipCommand::class, 'shared-maintenance-file-zip', [
            '--days' => 15,
            '--folder' => 'storage/logs',
            '--extensions' => ['json', 'log'],
        ])->dailyAt('01:05');
    }
}
