<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class ProfileTelegram extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'telegram' => ['bail', 'required', 'array'],
            'telegram.username' => ['bail', 'string'],
            'password_current' => ['bail', 'required', 'current_password'],
        ];
    }
}
