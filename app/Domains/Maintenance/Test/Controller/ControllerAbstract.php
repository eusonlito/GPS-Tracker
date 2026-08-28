<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Test\Controller;

use App\Domains\CoreApp\Test\Controller\ControllerAbstract as CoreAppControllerAbstract;
use App\Domains\Expense\Model\Expense as ExpenseModel;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as ExpenseCategoryModel;
use App\Domains\Maintenance\Model\Maintenance as Model;

abstract class ControllerAbstract extends CoreAppControllerAbstract
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * @param \App\Domains\Maintenance\Model\Maintenance $row
     *
     * @return \App\Domains\Expense\Model\Expense
     */
    protected function assertExpenseSynced(Model $row): ExpenseModel
    {
        $row->load('expense');

        $this->assertNotNull($row->expense);
        $this->assertTrue($row->expense()->exists());
        $this->assertEquals(1, $row->expense()->count());

        $expense = $row->expense;

        $this->assertEquals($row->id, $expense->maintenance_id);
        $this->assertNull($expense->refuel_id);
        $this->assertTrue($expense->isRelated());

        $this->assertNotNull($expense->maintenance);
        $this->assertEquals($row->id, $expense->maintenance->id);
        $this->assertEquals(
            ExpenseCategoryModel::query()->byCode('maintenance')->value('id'),
            $expense->expense_category_id
        );
        $this->assertEquals('maintenance', $expense->category->code);

        $this->assertEquals($row->name, $expense->name);
        $this->assertEquals($row->description, $expense->description);
        $this->assertEquals((float)$row->amount, (float)$expense->amount);
        $this->assertEquals(substr((string)$row->date_at, 0, 10), substr((string)$expense->date_at, 0, 10));
        $this->assertEquals((float)$row->distance, (float)$expense->distance);
        $this->assertEquals($row->user_id, $expense->user_id);
        $this->assertEquals($row->vehicle_id, $expense->vehicle_id);

        $this->assertDatabaseHas(ExpenseModel::TABLE, [
            'id' => $expense->id,
            'name' => $row->name,
            'description' => $row->description,
            'amount' => $row->amount,
            'date_at' => substr((string)$row->date_at, 0, 10),
            'distance' => $row->distance,
            'expense_category_id' => $expense->expense_category_id,
            'user_id' => $row->user_id,
            'vehicle_id' => $row->vehicle_id,
            'maintenance_id' => $row->id,
            'refuel_id' => null,
        ]);

        return $expense;
    }
}
