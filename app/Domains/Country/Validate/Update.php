<?php declare(strict_types=1);

namespace App\Domains\Country\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => ['bail', 'required'],
            'name' => ['bail', 'required'],
            'alias' => ['bail'],
        ];
    }
}
