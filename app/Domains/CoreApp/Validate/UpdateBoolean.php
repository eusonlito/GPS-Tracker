<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

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
            'column.required' => __('validator.column-required'),
        ];
    }
}
