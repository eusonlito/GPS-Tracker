<?php declare(strict_types=1);

namespace App\Domains\City\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class GetOrNew extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'latitude' => ['bail', 'required', 'numeric', 'between:-90,90'],
            'longitude' => ['bail', 'required', 'numeric', 'between:-180,180'],
        ];
    }
}
