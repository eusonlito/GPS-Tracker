<?php

namespace App\Domains\User\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermissions
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();
        // Kiểm tra nếu user chưa đăng nhập hoặc không có quyền
        if (!$user || !$user->can($permission)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
