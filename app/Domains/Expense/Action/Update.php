<?php declare(strict_types=1);

namespace App\Domains\Expense\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->description = $this->data['description'];
        $this->row->amount = $this->data['amount'];
        $this->row->date_at = $this->data['date_at'];
        $this->row->distance = $this->data['distance'];
        $this->row->expense_category_id = $this->data['expense_category_id'];
        $this->row->vehicle_id = $this->data['vehicle_id'];

        $this->row->save();
    }
}
