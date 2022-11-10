<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => ['bail', 'required'],
            'config' => ['bail', 'array', 'nullable'],
            'enabled' => ['bail', 'boolean'],
        ];
    }
}
