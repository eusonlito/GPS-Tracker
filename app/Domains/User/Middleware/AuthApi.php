<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request as RequestVendor;
use Illuminate\Http\Response;

class AuthApi extends MiddlewareAbstract
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
            $this->factory()->action()->authApi();
        } catch (Exception $e) {
            return $this->fail($e);
        }

        return $next($request);
    }

    /**
     * @param \Exception $e
     *
     * @return \Illuminate\Http\Response
     */
    protected function fail(Exception $e): Response
    {
        if (helper()->isExceptionSystem($e)) {
            report($e);
        }

        return response(null, 401);
    }
}
