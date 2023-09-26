<?php declare(strict_types=1);

namespace App\Domains\State\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\State\Model\State as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\State\Model\State
     */
    protected ?Model $row;
}
