<?php declare(strict_types=1);

namespace App\Domains\UserSession\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\UserSession\Model\UserSession as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\UserSession\Model\UserSession
     */
    protected ?Model $row;
}
