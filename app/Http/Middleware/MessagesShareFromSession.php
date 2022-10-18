<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MessagesShareFromSession
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $message = service()->message()->instance();

        $message->request($request);
        $message->session($request->session());

        return $next($request);
    }
}
