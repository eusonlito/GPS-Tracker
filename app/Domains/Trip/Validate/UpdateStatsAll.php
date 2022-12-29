<?php declare(strict_types=1);

namespace App\Domains\Trip\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class UpdateStatsAll extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'overwrite' => ['bail', 'boolean'],
        ];
    }
}
