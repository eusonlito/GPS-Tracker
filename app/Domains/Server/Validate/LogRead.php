<?php declare(strict_types=1);

namespace App\Domains\Server\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class LogRead extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'protocol' => ['bail', 'required'],
            'file' => ['bail', 'required'],
        ];
    }
}
