<?php declare(strict_types=1);

namespace App\Domains\Shared\Job\Middleware;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class RateLimit
{
    /**
     * @param \Illuminate\Contracts\Queue\ShouldQueue $job
     * @param callable $next
     *
     * @return void
     */
    final public function handle(ShouldQueue $job, callable $next)
    {
        Redis::throttle('RateLimitJob')
            ->block(30)
            ->allow(1)
            ->every(10)
            ->then(
                fn () => $this->send($job, $next),
                fn () => $this->fail($job),
            );
    }

    /**
     * @param \Illuminate\Contracts\Queue\ShouldQueue $job
     * @param callable $next
     *
     * @return void
     */
    final public function send(ShouldQueue $job, callable $next)
    {
        $job->handle();

        $next($job);
    }

    /**
     * @param \Illuminate\Contracts\Queue\ShouldQueue $job
     *
     * @return void
     */
    final public function fail(ShouldQueue $job)
    {
        $job->release(10);
    }
}
