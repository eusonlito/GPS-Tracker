<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\Trip\Model\Trip as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Trip\Model\Trip
     */
    protected ?Model $row;
}
