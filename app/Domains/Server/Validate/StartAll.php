<?php declare(strict_types=1);

namespace App\Domains\Server\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class StartAll extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'reset' => ['bail', 'boolean'],
            'debug' => ['bail', 'boolean'],
        ];
    }
}
