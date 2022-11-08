<?php declare(strict_types=1);

namespace App\Domains\Device\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class UpdateDeviceMessageDelete extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'device_message_id' => ['bail', 'required', 'integer'],
        ];
    }
}
