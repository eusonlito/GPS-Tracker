<?php declare(strict_types=1);

namespace App\Domains\Position\Action;

use App\Domains\Position\Model\Position as Model;
use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Position\Model\Position
     */
    protected ?Model $row;
}
