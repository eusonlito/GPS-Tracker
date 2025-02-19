<?php

declare(strict_types=1);

namespace App\Domains\Role\Action;

use App\Domains\Role\Model\Role as Model;
use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Role\Model\Role
     */
    protected ?Model $row;
}
