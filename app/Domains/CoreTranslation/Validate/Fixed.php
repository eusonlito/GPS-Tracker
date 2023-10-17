<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Fixed extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'paths-exclude' => ['bail', 'array'],
        ];
    }
}
