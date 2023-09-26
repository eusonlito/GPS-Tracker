<?php declare(strict_types=1);

namespace App\Domains\Alarm\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class CheckPosition extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'position_id' => ['bail', 'required', 'integer'],
        ];
    }
}
