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
    public function handle(Request $request, Closure $next): mixed
    {
        if ($this->exists($request) === false) {
            return redirect()->route('vehicle.create');
        }

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function exists(Request $request): bool
    {
        return Model::query()
            ->byUserId($request->user()->id)
            ->exists();
    }
}
