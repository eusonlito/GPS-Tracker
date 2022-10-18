<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Request\Response;

class Reset
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->response();
        $this->message();

        return $next($request);
    }

    /**
     * @return void
     */
    protected function response(): void
    {
        Response::status(200);
    }

    /**
     * @return void
     */
    protected function message(): void
    {
        service()->message()->reset();
    }
}
