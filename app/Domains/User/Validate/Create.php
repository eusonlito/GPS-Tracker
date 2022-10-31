<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'email' => ['bail', 'required', 'email:filter'],
            'password' => ['bail', 'required', 'min:8'],
            'admin' => ['bail', 'nullable', 'boolean'],
            'enabled' => ['bail', 'nullable', 'boolean'],
            'language_id' => ['bail', 'nullable', 'integer'],
        ];
    }
}
