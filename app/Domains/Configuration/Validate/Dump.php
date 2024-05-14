<?php declare(strict_types=1);

namespace App\Domains\Configuration\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Dump extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'config' => ['bail', 'boolean'],
            'server' => ['bail', 'boolean'],
            'only' => ['bail', 'string', 'nullable'],
        ];
    }
}
