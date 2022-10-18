<?php declare(strict_types=1);

namespace App\Domains\Socket\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class ServerPorts extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'reset' => ['bail', 'boolean'],
            'ports' => ['bail', 'required', 'array'],
        ];
    }
}
