<?php declare(strict_types=1);

namespace App\Domains\Configuration\Middleware;

use Closure;
use Illuminate\Http\Request as RequestVendor;
use App\Domains\Core\Middleware\MiddlewareAbstract;

class Request extends MiddlewareAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(RequestVendor $request, Closure $next): mixed
    {
        $this->factory()->action()->request();

        return $next($request);
    }
}
