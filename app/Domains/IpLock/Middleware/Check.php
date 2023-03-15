<?php declare(strict_types=1);

namespace App\Domains\IpLock\Middleware;

use Closure;
use Illuminate\Http\Request;

class Check extends MiddlewareAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->factory()->action()->check();

        return $next($request);
    }
}
