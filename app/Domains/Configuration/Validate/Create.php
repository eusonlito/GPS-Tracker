<?php declare(strict_types=1);

namespace App\Domains\Configuration\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'key' => ['bail', 'required'],
            'value' => ['bail', 'required'],
            'description' => ['bail', 'required'],
        ];
    }
}
