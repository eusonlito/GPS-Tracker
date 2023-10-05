<?php declare(strict_types=1);

namespace App\Domains\UserSession\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserSession\Model\UserSession as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\UserSession\Model\UserSession
     */
    protected ?Model $row;

    /**
     * @var \App\Domains\User\Model\User
     */
    protected UserModel $user;
}
