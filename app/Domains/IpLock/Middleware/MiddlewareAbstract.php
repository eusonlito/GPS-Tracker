<?php declare(strict_types=1);

namespace App\Domains\IpLock\Middleware;

use App\Domains\Core\Middleware\MiddlewareAbstract as MiddlewareAbstractCore;
use App\Domains\IpLock\Model\IpLock as Model;

abstract class MiddlewareAbstract extends MiddlewareAbstractCore
{
    /**
     * @var ?\App\Domains\IpLock\Model\IpLock
     */
    protected ?Model $row;
}
