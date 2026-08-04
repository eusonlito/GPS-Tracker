<?php declare(strict_types=1);

namespace App\Domains\Expense\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\Expense\Model\Expense as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Expense\Model\Expense
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\Expense\Model\Expense
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->byUserOrManager($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('expense.error.not-found')));
    }
}
