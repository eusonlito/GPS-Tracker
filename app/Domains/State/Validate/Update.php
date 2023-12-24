<?php declare(strict_types=1);

namespace App\Domains\State\Validate;

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
            'alias' => ['bail'],
            'country_id' => ['bail', 'required', 'integer'],
        ];
    }
}
