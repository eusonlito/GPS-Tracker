<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as Model;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\ExpenseCategory\Model\ExpenseCategory
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\ExpenseCategory\Model\ExpenseCategory
     */
    public function create(): Model
    {
        return $this->actionHandleTransaction(Create::class, $this->validate()->create());
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandleTransaction(Delete::class);
    }

    /**
     * @return \App\Domains\ExpenseCategory\Model\ExpenseCategory
     */
    public function update(): Model
    {
        return $this->actionHandleTransaction(Update::class, $this->validate()->update());
    }
}
