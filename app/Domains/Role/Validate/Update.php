<?php declare(strict_types=1);

namespace App\Domains\Alarm\Validate;

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
            'telegram' => ['bail', 'boolean'],
            'enabled' => ['bail', 'boolean'],
            'schedule_start' => ['bail', 'nullable', 'date_format:H:i'],
            'schedule_end' => ['bail', 'nullable', 'date_format:H:i'],
        ];
    }
}
