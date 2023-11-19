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
    public function handle(Request $request, Closure $next): mixed
    {
        $this->factory()->action($this->actionData($request))->check();

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function actionData(Request $request): array
    {
        return [
            'ip' => $request->ip(),
        ];
    }
}
