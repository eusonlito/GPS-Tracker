<?php declare(strict_types=1);

namespace App\Domains\Expense\Action;

use App\Domains\Expense\Model\Expense as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'name' => $this->data['name'],
            'description' => $this->data['description'],
            'amount' => $this->data['amount'],
            'date_at' => $this->data['date_at'],
            'distance' => $this->data['distance'],
            'expense_category_id' => $this->data['expense_category_id'],
            'user_id' => $this->data['user_id'],
            'vehicle_id' => $this->data['vehicle_id'],
            'maintenance_id' => null,
            'refuel_id' => null,
        ]);
    }
}
