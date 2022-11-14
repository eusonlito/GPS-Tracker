<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

abstract class UpdateBoolean extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'column' => 'bail|required|string',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'column.required' => __('validate.column.required'),
        ];
    }
}
