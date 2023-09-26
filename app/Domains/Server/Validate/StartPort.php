<?php declare(strict_types=1);

namespace App\Domains\Server\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class StartPort extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'port' => ['bail', 'integer', 'required'],
            'reset' => ['bail', 'boolean'],
            'debug' => ['bail', 'boolean'],
        ];
    }
}
