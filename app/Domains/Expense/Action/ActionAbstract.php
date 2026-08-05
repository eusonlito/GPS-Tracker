<?php declare(strict_types=1);

namespace App\Domains\Expense\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\Expense\Model\Expense as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Expense\Model\Expense
     */
    protected ?Model $row;
}
