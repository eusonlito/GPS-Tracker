<?php declare(strict_types=1);

namespace App\Domains\City\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'alias' => ['bail', 'string'],
            'latitude' => ['bail', 'numeric', 'required'],
            'longitude' => ['bail', 'numeric', 'required'],
            'state_id' => ['bail', 'required', 'integer'],
            'country_id' => ['bail', 'required', 'integer'],
        ];
    }
}
