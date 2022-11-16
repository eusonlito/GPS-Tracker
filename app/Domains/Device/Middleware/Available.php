<?php declare(strict_types=1);

namespace App\Domains\Device\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Domains\Device\Model\Device as Model;

class Available extends MiddlewareAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Model::query()->byUserId($request->user()->id)->count() === 0) {
            return redirect()->route('device.create');
        }

        return $next($request);
    }
}
