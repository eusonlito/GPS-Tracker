<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Action;

use App\Domains\ExpenseCategory\Model\ExpenseCategory as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function data(): void
    {
        parent::data();

        $this->data['code'] = null;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'name' => $this->data['name'],
            'code' => null,
            'user_id' => $this->data['user_id'],
        ]);
    }
}
