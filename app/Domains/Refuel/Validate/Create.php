<?php declare(strict_types=1);

namespace App\Domains\Refuel\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'distance' => ['bail', 'required', 'numeric'],
            'distance_total' => ['bail', 'required', 'numeric'],
            'quantity' => ['bail', 'required', 'numeric'],
            'quantity_before' => ['bail', 'numeric'],
            'price' => ['bail', 'required', 'numeric'],
            'total' => ['bail', 'required', 'numeric'],
            'date_at' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'vehicle_id' => ['bail', 'required', 'integer'],
        ];
    }
}
