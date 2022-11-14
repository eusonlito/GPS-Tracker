<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => ['bail', 'required'],
            'config' => ['bail', 'array'],
            'enabled' => ['bail', 'boolean'],
            'device_id' => ['bail', 'required', 'integer'],
        ];
    }
}
