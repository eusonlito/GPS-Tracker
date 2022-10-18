<?php declare(strict_types=1);

namespace App\Domains\Socket\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class KillPorts extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'ports' => ['bail', 'required', 'array'],
            'ports.*' => ['bail', 'required', 'integer'],
        ];
    }
}
