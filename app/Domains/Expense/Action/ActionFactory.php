<?php declare(strict_types=1);

namespace App\Domains\Expense\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\Expense\Model\Expense as Model;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Expense\Model\Expense
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\Expense\Model\Expense
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
     * @return \App\Domains\Expense\Model\Expense
     */
    public function update(): Model
    {
        return $this->actionHandleTransaction(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\Expense\Model\Expense
     */
    public function upsertFromMaintenance(): Model
    {
        return $this->actionHandleTransaction(UpsertFromMaintenance::class, $this->data);
    }

    /**
     * @return \App\Domains\Expense\Model\Expense
     */
    public function upsertFromRefuel(): Model
    {
        return $this->actionHandleTransaction(UpsertFromRefuel::class, $this->data);
    }
}
