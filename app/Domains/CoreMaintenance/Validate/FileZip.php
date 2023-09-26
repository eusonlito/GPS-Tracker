<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class FileZip extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'days' => ['bail', 'required', 'integer', 'gt:0'],
            'folder' => ['bail', 'required', 'string'],
            'extensions' => ['bail', 'required', 'array'],
        ];
    }
}
