<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Schedule;

use App\Domains\Core\Schedule\ScheduleAbstract;
use App\Domains\CoreMaintenance\Command\CurlCacheClean as CurlCacheCleanCommand;
use App\Domains\CoreMaintenance\Command\DirectoryEmptyDelete as DirectoryEmptyDeleteCommand;
use App\Domains\CoreMaintenance\Command\FileDeleteOld as FileDeleteOldCommand;
use App\Domains\CoreMaintenance\Command\FileZip as FileZipCommand;

class Manager extends ScheduleAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->cachePruneStaleTags();
        $this->queuePruneFailed();
        $this->fileZip();
        $this->fileDeleteOld();
        $this->curlCacheClean();
        $this->directoryEmptyDelete();
    }

    /**
     * @return void
     */
    protected function cachePruneStaleTags(): void
    {
        $this->command('cache:prune-stale-tags', 'cache-prune-stale-tags')
            ->hourly();
    }

    /**
     * @return void
     */
    protected function queuePruneFailed(): void
    {
        $this->command('queue:prune-failed', 'queue-prune-failed', [
            '--hours' => 120,
        ])->daily();
    }

    /**
     * @return void
     */
    protected function fileZip(): void
    {
        $this->command(FileZipCommand::class, 'core-maintenance-file-zip')
            ->dailyAt('01:05');
    }

    /**
     * @return void
     */
    protected function fileDeleteOld(): void
    {
        $this->command(FileDeleteOldCommand::class, 'core-maintenance-file-delete-old')
            ->dailyAt('01:15');
    }

    /**
     * @return void
     */
    protected function curlCacheClean(): void
    {
        $this->command(CurlCacheCleanCommand::class, 'core-maintenance-curl-cache-clean')
            ->dailyAt('01:20');
    }

    /**
     * @return void
     */
    protected function directoryEmptyDelete(): void
    {
        $this->command(DirectoryEmptyDeleteCommand::class, 'core-maintenance-directory-empty-delete')
            ->dailyAt('01:25');
    }
}
