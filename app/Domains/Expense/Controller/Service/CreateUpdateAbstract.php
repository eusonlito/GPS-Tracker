<?php declare(strict_types=1);

namespace App\Domains\Expense\Controller\Service;

use App\Domains\ExpenseCategory\Model\Collection\ExpenseCategory as ExpenseCategoryCollection;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as ExpenseCategoryModel;

abstract class CreateUpdateAbstract extends ControllerAbstract
{
    /**
     * @return void
     */
    protected function request(): void
    {
        $this->requestMergeWithRow([
            'user_id' => $this->user()->id,
        ]);
    }

    /**
     * @return array
     */
    protected function dataCreateUpdate(): array
    {
        return $this->dataCore() + [
            'vehicles' => $this->vehicles(),
            'categories' => $this->categories(),
        ];
    }

    /**
     * @return \App\Domains\ExpenseCategory\Model\Collection\ExpenseCategory
     */
    protected function categories(): ExpenseCategoryCollection
    {
        return $this->cache(
            fn () => ExpenseCategoryModel::query()
                ->byUserIdOrNull($this->user()->id)
                ->list()
                ->get()
        );
    }
}
