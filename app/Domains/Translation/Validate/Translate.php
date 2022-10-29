<?php declare(strict_types=1);

namespace App\Domains\Translation\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Translate extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'from' => ['bail', 'required'],
            'to' => ['bail', 'required'],
        ];
    }
}
