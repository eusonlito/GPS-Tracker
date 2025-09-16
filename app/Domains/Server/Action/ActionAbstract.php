<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\Server\Model\Server as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Server\Model\Server
     */
    protected ?Model $row;
}
