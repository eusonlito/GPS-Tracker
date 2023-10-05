<?php declare(strict_types=1);

namespace App\Domains\UserFail\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserFail\Model\UserFail as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\UserFail\Model\UserFail
     */
    protected ?Model $row;

    /**
     * @var \App\Domains\User\Model\User
     */
    protected UserModel $user;
}
