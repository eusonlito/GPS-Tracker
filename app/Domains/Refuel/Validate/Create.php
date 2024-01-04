<?php declare(strict_types=1);

namespace App\Domains\Refuel\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

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
            'latitude' => ['bail', 'required', 'numeric', 'between:-90,90'],
            'longitude' => ['bail', 'required', 'numeric', 'between:-180,180'],
            'date_at' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'user_id' => ['bail', 'integer'],
            'vehicle_id' => ['bail', 'required', 'integer'],
        ];
    }
}
