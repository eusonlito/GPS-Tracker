<?php declare(strict_types=1);

namespace App\Domains\Trip\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'string'],
            'start_at' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'start_utc_at' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'end_at' => ['bail', 'nullable', 'date_format:Y-m-d H:i:s'],
            'end_utc_at' => ['bail', 'nullable', 'date_format:Y-m-d H:i:s'],
            'device_id' => ['bail', 'required', 'integer'],
            'timezone_id' => ['bail', 'required', 'integer'],
        ];
    }
}
