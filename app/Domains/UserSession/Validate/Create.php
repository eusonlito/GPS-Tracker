<?php declare(strict_types=1);

namespace App\Domains\UserSession\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'auth' => ['bail', 'required'],
            'ip' => ['bail', 'nullable'],
            'user_id' => ['bail', 'required', 'integer'],
        ];
    }
}
