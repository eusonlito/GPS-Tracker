<?php declare(strict_types=1);

namespace App\Domains\Monitor\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class QueueFailedRetry extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['bail', 'integer', 'required'],
        ];
    }
}
