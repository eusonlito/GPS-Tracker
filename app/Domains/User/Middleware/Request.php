<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request as RequestVendor;

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
        try {
            $this->factory()->action()->request();
        } catch (Exception $e) {
            return $this->fail($request, $e);
        }

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     *
     * @return mixed
     */
    protected function fail(RequestVendor $request, Exception $e): mixed
    {
        if (helper()->isExceptionSystem($e)) {
            report($e);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response('Unauthorized.', 401);
        }

        return redirect()->route('user.auth.credentials');
    }
}
