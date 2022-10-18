<?php declare(strict_types=1);

namespace App\Domains\City\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class GetOrNew extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'latitude' => ['bail', 'required', 'numeric'],
            'longitude' => ['bail', 'required', 'numeric'],
        ];
    }
}
