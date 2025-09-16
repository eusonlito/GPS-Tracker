<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\IpLock\Model\IpLock as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\IpLock\Model\IpLock
     */
    protected ?Model $row;
}
