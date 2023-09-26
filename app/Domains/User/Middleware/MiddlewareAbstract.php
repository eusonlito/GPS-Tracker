<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Illuminate\Http\Request;
use App\Domains\Core\Middleware\MiddlewareAbstract as MiddlewareAbstractCore;
use App\Domains\User\Model\User as Model;

abstract class MiddlewareAbstract extends MiddlewareAbstractCore
{
    /**
     * @var ?\App\Domains\User\Model\User
     */
    protected ?Model $row;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function load(Request $request): void
    {
        $this->auth = $this->row = $request->user();
    }
}
