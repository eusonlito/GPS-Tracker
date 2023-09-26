<?php declare(strict_types=1);

namespace App\Domains\Core\Job;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Domains\Core\Traits\Factory;

abstract class JobAbstract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Factory;

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    public function failed(Throwable $e): void
    {
        if (app()->bound('sentry')) {
            app('sentry')->captureException($e);
        }
    }
}
