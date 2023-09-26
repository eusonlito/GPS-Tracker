<?php declare(strict_types=1);

namespace App\Domains\Server\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'port' => ['bail', 'integer', 'required'],
            'protocol' => ['bail', 'string', 'required'],
            'debug' => ['bail', 'boolean'],
            'enabled' => ['bail', 'boolean'],
        ];
    }
}
