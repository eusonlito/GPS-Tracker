<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'global' => ['bail', 'boolean'],
            'user_id' => ['bail', 'integer'],
        ];
    }
}
