<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Domains\Vehicle\Model\Vehicle as Model;

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
            return redirect()->route('vehicle.create');
        }

        return $next($request);
    }
}
