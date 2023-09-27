<?php declare(strict_types=1);

namespace App\Domains\Core\Job\Middleware;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class RateLimit
{
    /**
     * @param \Illuminate\Contracts\Queue\ShouldQueue $job
     * @param callable $next
     * @param int $block = 30
     * @param int $allow = 1
     * @param int $every = 10
     *
     * @return void
     */
    final public function handle(
        ShouldQueue $job,
        callable $next,
        int $block = 30,
        int $allow = 1,
        int $every = 10
    ) {
        Redis::throttle('RateLimitJob')
            ->block($block)
            ->allow($allow)
            ->every($every)
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
    final public function send(ShouldQueue $job, callable $next): void
    {
        $job->handle();

        $next($job);
    }

    /**
     * @param \Illuminate\Contracts\Queue\ShouldQueue $job
     *
     * @return void
     */
    final public function fail(ShouldQueue $job): void
    {
        $job->release(10);
    }
}
