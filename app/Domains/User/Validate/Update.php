<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'email' => ['bail', 'required', 'email:filter'],
            'password' => ['bail', 'min:8'],
            'admin' => ['bail', 'boolean'],
            'enabled' => ['bail', 'boolean'],
            'language_id' => ['bail', 'required', 'integer'],
        ];
    }
}
