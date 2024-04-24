<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class FileDeleteOlder extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'days' => ['bail', 'integer', 'gt:0', 'required'],
            'folder' => ['bail', 'string', 'required'],
            'extensions' => ['bail', 'array', 'in:log,zip,json', 'required'],
        ];
    }
}
