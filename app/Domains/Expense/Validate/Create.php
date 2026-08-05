<?php declare(strict_types=1);

namespace App\Domains\Expense\Validate;

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
            'description' => ['bail'],
            'amount' => ['bail', 'required', 'numeric'],
            'date_at' => ['bail', 'required', 'date_format:Y-m-d'],
            'distance' => ['bail', 'nullable', 'numeric'],
            'expense_category_id' => ['bail', 'required', 'integer'],
            'user_id' => ['bail', 'integer'],
            'vehicle_id' => ['bail', 'required', 'integer'],
        ];
    }
}
