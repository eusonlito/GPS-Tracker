<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use Illuminate\Validation\Rule;
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
            'email' => ['bail', 'required', 'email:filter'],
            'password' => ['bail', 'min:8'],
            'admin' => ['bail', 'boolean'],
            'manager' => ['bail', 'boolean'],
            'enabled' => ['bail', 'boolean'],
            'preferences' => ['bail', 'array'],
            'preferences.units' => ['bail', 'array'],
            'preferences.units.decimal' => ['bail', Rule::in([',', '.'])],
            'preferences.units.distance' => ['bail', 'in:kilometer,mile'],
            'preferences.units.money' => ['bail', 'in:euro,dollar'],
            'preferences.units.thousand' => ['bail', Rule::in([',', '.'])],
            'preferences.units.volume' => ['bail', 'in:liter,gallon'],
            'language_id' => ['bail', 'nullable', 'integer'],
            'timezone_id' => ['bail', 'nullable', 'integer'],
        ];
    }
}
