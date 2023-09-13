<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'workshop' => ['bail'],
            'date_at' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'distance' => ['bail', 'required', 'numeric'],
            'distance_next' => ['bail', 'numeric'],
            'amount' => ['bail', 'required', 'numeric'],
            'description' => ['bail'],
            'vehicle_id' => ['bail', 'required', 'integer'],
        ];
    }
}
