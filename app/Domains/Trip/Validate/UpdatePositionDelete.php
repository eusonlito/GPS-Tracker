<?php declare(strict_types=1);

namespace App\Domains\Trip\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class UpdatePositionDelete extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'position_ids' => ['bail', 'required', 'array'],
        ];
    }
}
