<?php declare(strict_types=1);

namespace App\Domains\Profile\Action;

use App\Domains\Core\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\User\Model\User as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\User\Model\User
     */
    protected ?Model $row;
}
