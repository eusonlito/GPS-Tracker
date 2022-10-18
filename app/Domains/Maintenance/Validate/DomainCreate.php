<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

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
            'fractal' => ['bail', 'boolean'],
            'middleware' => ['bail', 'boolean'],
            'mail' => ['bail', 'boolean'],
            'model' => ['bail', 'boolean'],
            'schedule' => ['bail', 'boolean'],
            'seeder' => ['bail', 'boolean'],
            'validate' => ['bail', 'boolean'],
        ];
    }
}
