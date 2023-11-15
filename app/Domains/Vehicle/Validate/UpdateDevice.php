<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class UpdateDevice extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'related' => ['bail', 'array'],
            'related.*' => ['bail', 'integer'],
        ];
    }
}
