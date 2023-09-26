<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Update extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'config' => ['bail', 'array'],
            'enabled' => ['bail', 'boolean'],
        ];
    }
}
