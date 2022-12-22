<?php declare(strict_types=1);

namespace App\Domains\Device\Validate;

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
            'maker' => ['bail', 'required'],
            'serial' => ['bail', 'required'],
            'phone_number' => ['bail', 'string'],
            'password' => ['bail', 'string'],
            'vehicle_id' => ['bail', 'required', 'integer'],
            'enabled' => ['bail', 'boolean'],
        ];
    }
}
