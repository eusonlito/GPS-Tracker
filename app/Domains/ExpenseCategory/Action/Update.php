<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->user_id = $this->data['user_id'];
        $this->row->save();
    }
}
