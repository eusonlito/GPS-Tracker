<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Translate extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'from' => ['bail', 'required'],
            'to' => ['bail', 'array', 'required'],
        ];
    }
}
