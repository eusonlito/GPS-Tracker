<?php declare(strict_types=1);

namespace App\Domains\UserFail\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => ['bail', 'required'],
            'text' => ['bail', 'required'],
            'ip' => ['bail', 'nullable'],
            'user_id' => ['bail', 'integer', 'nullable'],
        ];
    }
}
