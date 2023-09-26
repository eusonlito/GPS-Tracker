<?php declare(strict_types=1);

namespace App\Domains\Profile\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class UpdateTelegram extends ValidateAbstract
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
