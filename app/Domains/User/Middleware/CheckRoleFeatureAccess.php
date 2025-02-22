<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleFeatureAccess
{
    public function handle(Request $request, Closure $next, string $roleFeature)
    {
        if (!Auth::check() || !Auth::user()->hasRoleFeatureAccess($roleFeature)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
