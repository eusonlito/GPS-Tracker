<?php

declare(strict_types=1);

namespace App\Domains\Enterprise\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEnterpriseAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $enterpriseId = $request->route('enterprise');

        if (!$user || $user->enterprise_id != $enterpriseId) {
            abort(403, 'Bạn không có quyền truy cập doanh nghiệp này');
        }

        return $next($request);
    }
}
