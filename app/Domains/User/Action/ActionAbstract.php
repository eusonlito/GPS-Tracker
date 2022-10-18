<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\Shared\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\User\Model\User as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\User\Model\User
     */
    protected ?Model $row;
}
