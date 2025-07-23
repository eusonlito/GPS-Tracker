<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Validate;

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
            'plate' => ['bail'],
            'timezone_auto' => ['bail', 'boolean'],
            'enabled' => ['bail', 'boolean'],
            'timezone_id' => ['bail', 'required', 'integer'],
            'user_id' => ['bail', 'integer'],
            'config' => ['bail', 'array', 'required'],
            'config.trip_wait_minutes' => ['bail', 'integer', 'min:0'],
        ];
    }
}
