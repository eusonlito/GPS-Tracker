<?php declare(strict_types=1);

namespace App\Domains\State\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class GetOrNew extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'country_id' => ['bail', 'required', 'integer'],
        ];
    }
}
