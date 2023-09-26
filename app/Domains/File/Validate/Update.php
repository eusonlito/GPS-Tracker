<?php declare(strict_types=1);

namespace App\Domains\File\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => ['bail', 'required', 'file'],
        ];
    }
}
