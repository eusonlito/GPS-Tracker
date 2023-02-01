<?php declare(strict_types=1);

namespace App\Domains\Trip\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required', 'string'],
            'shared' => ['bail', 'boolean'],
        ];
    }
}
