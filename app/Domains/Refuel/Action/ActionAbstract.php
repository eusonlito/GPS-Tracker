<?php declare(strict_types=1);

namespace App\Domains\Refuel\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\Refuel\Model\Refuel as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Refuel\Model\Refuel
     */
    protected ?Model $row;
}
