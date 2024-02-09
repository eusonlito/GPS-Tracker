<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class DirectoryEmptyDelete extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'folder' => ['bail', 'required', 'string'],
        ];
    }
}
