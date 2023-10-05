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
            'ip' => ['bail', 'nullable'],
        ];
    }
}
