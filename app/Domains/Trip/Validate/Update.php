<?php declare(strict_types=1);

namespace App\Domains\Trip\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => ['bail', 'required', 'uuid'],
            'name' => ['bail', 'required', 'string'],
            'shared' => ['bail', 'boolean'],
            'shared_public' => ['bail', 'boolean'],
        ];
    }
}
