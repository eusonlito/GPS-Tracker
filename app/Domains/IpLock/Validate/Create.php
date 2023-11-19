<?php declare(strict_types=1);

namespace App\Domains\IpLock\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'ip' => ['bail', 'required', 'ip'],
            'end_at' => ['bail', 'nullable', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
