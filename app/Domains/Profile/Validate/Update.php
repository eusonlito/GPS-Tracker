<?php declare(strict_types=1);

namespace App\Domains\Profile\Validate;

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
            'password_current' => ['bail', 'required', 'current_password'],
            'language_id' => ['bail', 'required', 'integer'],
        ];
    }
}
