<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class DomainCreate extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required', 'string'],
            'action' => ['bail', 'boolean'],
            'command' => ['bail', 'boolean'],
            'controller' => ['bail', 'boolean'],
            'exception' => ['bail', 'boolean'],
            'fractal' => ['bail', 'boolean'],
            'job' => ['bail', 'boolean'],
            'middleware' => ['bail', 'boolean'],
            'mail' => ['bail', 'boolean'],
            'model' => ['bail', 'boolean'],
            'schedule' => ['bail', 'boolean'],
            'seeder' => ['bail', 'boolean'],
            'test' => ['bail', 'boolean'],
            'validate' => ['bail', 'boolean'],
        ];
    }
}
