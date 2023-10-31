<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Validate;

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
            'workshop' => ['bail', 'required'],
            'date_at' => ['bail', 'required', 'date_format:Y-m-d'],
            'distance' => ['bail', 'required', 'numeric'],
            'distance_next' => ['bail', 'numeric'],
            'amount' => ['bail', 'numeric'],
            'description' => ['bail'],
            'user_id' => ['bail', 'integer'],
            'vehicle_id' => ['bail', 'required', 'integer'],
        ];
    }
}
