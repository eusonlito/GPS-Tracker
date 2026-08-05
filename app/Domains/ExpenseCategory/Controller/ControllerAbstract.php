<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\ExpenseCategory\Model\ExpenseCategory
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\ExpenseCategory\Model\ExpenseCategory
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->byUserOrManagerOrSystem($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('expense-category.error.not-found')));
    }
}
