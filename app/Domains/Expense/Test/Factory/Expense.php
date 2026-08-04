<?php declare(strict_types=1);

namespace App\Domains\Expense\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\Expense\Model\Expense as Model;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as ExpenseCategoryModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Expense extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Expense\Model\Expense>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Expense: '.$this->faker->name,
            'description' => $this->faker->text,
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'date_at' => date('Y-m-d'),
            'distance' => rand(100, 1000),
            'expense_category_id' => static fn () => ExpenseCategoryModel::query()->onlyUser()->orderBy('id', 'ASC')->first()
                ?: ExpenseCategoryModel::factory(),
            'user_id' => $this->userFirstOrFactory(),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
            'maintenance_id' => null,
            'refuel_id' => null,
        ];
    }
}
