<?php declare(strict_types=1);

namespace App\Domains\Socket\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Server extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'port' => ['bail', 'integer', 'required'],
            'reset' => ['bail', 'boolean'],
        ];
    }
}
