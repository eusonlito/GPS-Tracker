<?php declare(strict_types=1);

namespace App\Domains\Trip\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class UpdatePositionCreate extends ValidateAbstract
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
