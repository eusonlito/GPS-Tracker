<?php declare(strict_types=1);

namespace App\Domains\Core\Middleware;

use Illuminate\Http\Request;
use App\Domains\Core\Traits\Factory;

abstract class MiddlewareAbstract
{
    use Factory;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return self
     */
    final public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
