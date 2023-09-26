<?php declare(strict_types=1);

namespace App\Domains\Country\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class GetOrNew extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'code' => ['bail', 'required'],
        ];
    }
}
