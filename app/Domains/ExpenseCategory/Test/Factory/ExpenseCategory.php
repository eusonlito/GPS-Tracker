<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as Model;

class ExpenseCategory extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\ExpenseCategory\Model\ExpenseCategory>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Expense Category: '.$this->faker->name,
            'code' => null,
            'user_id' => $this->userFirstOrFactory(),
        ];
    }
}
