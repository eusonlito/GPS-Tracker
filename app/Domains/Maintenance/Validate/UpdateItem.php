<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class UpdateItem extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'maintenance_item_id' => ['array'],
            'maintenance_item_id.*' => ['integer'],
            'quantity' => ['array'],
            'quantity.*' => ['numeric', 'min:0'],
            'amount_gross' => ['array'],
            'amount_gross.*' => ['numeric', 'min:0'],
            'tax_percent' => ['array'],
            'tax_percent.*' => ['numeric', 'min:0'],
        ];
    }
}
