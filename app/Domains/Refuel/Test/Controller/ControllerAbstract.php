<?php declare(strict_types=1);

namespace App\Domains\Refuel\Test\Controller;

use App\Domains\CoreApp\Test\Controller\ControllerAbstract as CoreAppControllerAbstract;
use App\Domains\Expense\Model\Expense as ExpenseModel;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as ExpenseCategoryModel;
use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\Refuel\Test\Traits\Controller as ControllerTrait;

abstract class ControllerAbstract extends CoreAppControllerAbstract
{
    use ControllerTrait;

    /**
     * @param \App\Domains\Refuel\Model\Refuel $row
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

        $this->assertEquals($row->id, $expense->refuel_id);
        $this->assertNull($expense->maintenance_id);
        $this->assertTrue($expense->isRelated());

        $this->assertNotNull($expense->refuel);
        $this->assertEquals($row->id, $expense->refuel->id);
        $this->assertEquals(
            ExpenseCategoryModel::query()->byCode('refuel')->value('id'),
            $expense->expense_category_id
        );
        $this->assertEquals('refuel', $expense->category->code);

        $this->assertEquals(__('expense.sync.refuel'), $expense->name);
        $this->assertNull($expense->description);
        $this->assertEquals((float)$row->total, (float)$expense->amount);
        $this->assertEquals(substr((string)$row->date_at, 0, 10), substr((string)$expense->date_at, 0, 10));
        $this->assertEquals((float)$row->distance_total, (float)$expense->distance);
        $this->assertEquals($row->user_id, $expense->user_id);
        $this->assertEquals($row->vehicle_id, $expense->vehicle_id);

        $this->assertDatabaseHas(ExpenseModel::TABLE, [
            'id' => $expense->id,
            'name' => __('expense.sync.refuel'),
            'description' => null,
            'amount' => $row->total,
            'date_at' => substr((string)$row->date_at, 0, 10),
            'distance' => $row->distance_total,
            'expense_category_id' => $expense->expense_category_id,
            'user_id' => $row->user_id,
            'vehicle_id' => $row->vehicle_id,
            'maintenance_id' => null,
            'refuel_id' => $row->id,
        ]);

        return $expense;
    }
}
