<?php declare(strict_types=1);

namespace App\Domains\Trip\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class LastOrNew extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'speed' => ['bail', 'required', 'numeric'],
            'date_at' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'date_utc_at' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'device_id' => ['bail', 'required', 'integer'],
            'timezone_id' => ['bail', 'required', 'integer'],
        ];
    }
}
