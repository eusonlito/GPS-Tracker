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

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'auth.required' => __('user-session-create.validate.auth-required'),
            'user_id.required' => __('user-session-create.validate.user_id-required'),
            'user_id.integer' => __('user-session-create.validate.user_id-integer'),
        ];
    }
}
