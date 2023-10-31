<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'user_id' => ['bail', 'integer'],
        ];
    }
}
