<?php declare(strict_types=1);

namespace App\Domains\Device\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class UpdateTransfer extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['bail', 'integer', 'required'],
            'vehicle_id' => ['bail', 'integer'],
            'device_id' => ['bail', 'integer'],
        ];
    }
}
