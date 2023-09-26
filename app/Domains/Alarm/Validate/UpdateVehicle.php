<?php declare(strict_types=1);

namespace App\Domains\Alarm\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class UpdateVehicle extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'related' => ['bail', 'array'],
            'related.*' => ['bail', 'integer'],
        ];
    }
}
