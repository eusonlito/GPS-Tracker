<?php declare(strict_types=1);

namespace App\Domains\Expense\Action;

use App\Domains\Expense\Model\Expense as Model;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as ExpenseCategoryModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Expense\Model\Expense
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();
        $this->files();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataUserId();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkRelated();
        $this->checkVehicle();
        $this->checkCategory();
    }

    /**
     * @return void
     */
    protected function checkRelated(): void
    {
        if ($this->row?->isRelated()) {
            $this->exceptionValidator(__('expense-update.error.related'));
        }
    }

    /**
     * @return void
     */
    protected function checkVehicle(): void
    {
        if ($this->checkVehicleExists() === false) {
            $this->exceptionValidator(__('expense-create.error.vehicle-not-found'));
        }
    }

    /**
     * @return bool
     */
    protected function checkVehicleExists(): bool
    {
        return VehicleModel::query()
            ->select('id')
            ->byId($this->data['vehicle_id'])
            ->byUserId($this->data['user_id'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function checkCategory(): void
    {
        if ($this->checkCategoryExists() === false) {
            $this->exceptionValidator(__('expense-create.error.category-not-found'));
        }
    }

    /**
     * @return bool
     */
    protected function checkCategoryExists(): bool
    {
        return ExpenseCategoryModel::query()
            ->select('id')
            ->byId($this->data['expense_category_id'])
            ->byUserIdOrNull($this->data['user_id'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function files(): void
    {
        $this->factory('File')->action($this->filesData())->upload();
    }

    /**
     * @return array
     */
    protected function filesData(): array
    {
        return [
            'files' => $this->request->all('files')['files'] ?? [],
            'related_table' => $this->row->getTable(),
            'related_id' => $this->row->id,
            'user_id' => $this->data['user_id'] ?? $this->row->user_id,
        ];
    }
}
