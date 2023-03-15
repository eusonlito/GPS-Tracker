<?php declare(strict_types=1);

namespace App\Domains\IpLock\Middleware;

use App\Domains\Shared\Middleware\MiddlewareAbstract as MiddlewareAbstractShared;
use App\Domains\IpLock\Model\IpLock as Model;

abstract class MiddlewareAbstract extends MiddlewareAbstractShared
{
    /**
     * @var ?\App\Domains\IpLock\Model\IpLock
     */
    protected ?Model $row;
}
