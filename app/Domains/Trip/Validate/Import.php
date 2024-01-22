<?php declare(strict_types=1);

namespace App\Domains\Trip\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Import extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['bail', 'integer'],
            'device_id' => ['bail', 'required', 'integer'],
            'vehicle_id' => ['bail', 'required', 'integer'],
            'timezone_id' => ['bail', 'nullable', 'integer'],
            'file' => ['bail', 'required', 'file', 'mimes:xml,gpx', 'extensions:gpx'],
        ];
    }
}
