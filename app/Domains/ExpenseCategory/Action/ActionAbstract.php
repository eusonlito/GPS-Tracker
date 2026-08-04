<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\ExpenseCategory\Model\ExpenseCategory
     */
    protected ?Model $row;
}
