<?php declare(strict_types=1);

namespace App\Domains\Expense\Action;

use App\Domains\Expense\Model\Expense as Model;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as ExpenseCategoryModel;

class UpsertFromRefuel extends ActionAbstract
{
    /**
     * @return \App\Domains\Expense\Model\Expense
     */
    public function handle(): Model
    {
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->updateOrCreate(
            ['refuel_id' => $this->data['refuel_id']],
            [
                'name' => $this->data['name'],
                'description' => null,
                'amount' => $this->data['amount'],
                'date_at' => substr((string)$this->data['date_at'], 0, 10),
                'distance' => $this->data['distance'],
                'expense_category_id' => $this->categoryId(),
                'user_id' => $this->data['user_id'],
                'vehicle_id' => $this->data['vehicle_id'],
                'maintenance_id' => null,
            ]
        );
    }

    /**
     * @return int
     */
    protected function categoryId(): int
    {
        $id = ExpenseCategoryModel::query()
            ->byCode('refuel')
            ->value('id');

        if (empty($id)) {
            $this->exceptionValidator(__('expense-create.error.category-not-found'));
        }

        return (int)$id;
    }
}
