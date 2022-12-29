<?php declare(strict_types=1);

namespace App\Domains\Refuel\Action;

use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Refuel\Model\Refuel
     */
    protected ?Model $row;
}
