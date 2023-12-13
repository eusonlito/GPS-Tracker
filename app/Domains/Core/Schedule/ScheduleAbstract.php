<?php declare(strict_types=1);

namespace App\Domains\Core\Schedule;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use App\Domains\Core\Job\JobAbstract;
use App\Services\Filesystem\Directory;

abstract class ScheduleAbstract
{
    /**
     * @var \Illuminate\Console\Scheduling\Schedule
     */
    protected Schedule $schedule;

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    final public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @param string $command
     * @param string $log = ''
     * @param array $arguments = []
     *
     * @return \Illuminate\Console\Scheduling\Event
     */
    final protected function command(string $command, string $log = '', array $arguments = []): Event
    {
        $schedule = $this->schedule->command($command, $arguments)->runInBackground();

        if ($log) {
            $schedule->appendOutputTo($this->log('command', $log));
        }

        return $schedule;
    }

    /**
     * @param \App\Domains\Core\Job\JobAbstract $job
     * @param string $log = ''
     *
     * @return \Illuminate\Console\Scheduling\Event
     */
    final protected function job(JobAbstract $job, string $log = ''): Event
    {
        $job = $this->schedule->job($job)->withoutOverlapping(60);

        if ($log) {
            $job->appendOutputTo($this->log('job', $log));
        }

        return $job;
    }

    /**
     * @param string $type
     * @param string $name
     *
     * @return string
     */
    protected function log(string $type, string $name): string
    {
        $file = storage_path('logs/artisan/'.date('Y/m/d').'/schedule-'.$type.'-'.str_slug($name).'.log');

        Directory::create($file, true);

        return $file;
    }
}
