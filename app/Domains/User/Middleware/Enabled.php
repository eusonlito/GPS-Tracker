<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Closure;
use Illuminate\Http\Request;

class Enabled extends MiddlewareAbstract
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

        if (empty($this->auth->enabled) && ($request->route()->getName() !== 'user.disabled')) {
            return redirect()->route('user.disabled');
        }

        return $next($request);
    }
}
