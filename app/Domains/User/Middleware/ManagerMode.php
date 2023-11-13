<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Closure;
use Illuminate\Http\Request;

class ManagerMode extends MiddlewareAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->load($request);

        if (empty($this->auth->managerMode())) {
            abort(404);
        }

        return $next($request);
    }
}
