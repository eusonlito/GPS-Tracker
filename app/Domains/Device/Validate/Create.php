<?php declare(strict_types=1);

namespace App\Domains\Device\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => ['bail', 'required', 'uuid'],
            'name' => ['bail', 'required', 'string'],
            'model' => ['bail', 'required', 'string'],
            'serial' => ['bail', 'required', 'string'],
            'phone_number' => ['bail', 'string'],
            'password' => ['bail', 'string'],
            'user_id' => ['bail', 'integer'],
            'vehicle_id' => ['bail', 'nullable', 'integer'],
            'enabled' => ['bail', 'boolean'],
            'shared' => ['bail', 'boolean'],
            'shared_public' => ['bail', 'boolean'],
            'config' => ['bail', 'array', 'required'],
            'config.position_filter_distance' => ['bail', 'integer', 'min:0'],
        ];
    }
}
