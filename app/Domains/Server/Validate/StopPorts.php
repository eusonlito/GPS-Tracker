<?php declare(strict_types=1);

namespace App\Domains\Server\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class StopPorts extends ValidateAbstract
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
