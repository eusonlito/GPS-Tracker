<?php declare(strict_types=1);

namespace App\Domains\Trip\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class UpdateStatsAll extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'force' => ['bail', 'boolean'],
        ];
    }
}
