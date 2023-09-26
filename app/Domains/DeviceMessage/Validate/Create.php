<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'message' => ['bail', 'required'],
            'device_id' => ['bail', 'required', 'integer'],
        ];
    }
}
