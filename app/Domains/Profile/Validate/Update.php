<?php declare(strict_types=1);

namespace App\Domains\Profile\Validate;

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

            'admin_mode' => ['bail', 'boolean'],
            'manager_mode' => ['bail', 'boolean'],

            'password' => ['bail', 'min:8'],
            'password_current' => ['bail', 'required', 'current_password'],

            'api_key' => ['bail', 'nullable'],
            'api_key_enabled' => ['bail', 'boolean'],

            'preferences' => ['bail', 'required', 'array'],
            'preferences.units' => ['bail', 'required', 'array'],
            'preferences.units.decimal' => ['bail', 'required', Rule::in([',', '.'])],
            'preferences.units.distance' => ['bail', 'required', 'in:kilometer,knot,mile'],
            'preferences.units.money' => ['bail', 'string', 'in:euro,dollar'],
            'preferences.units.thousand' => ['bail', 'required', Rule::in([',', '.'])],
            'preferences.units.volume' => ['bail', 'required', 'in:liter,gallon'],

            'language_id' => ['bail', 'required', 'integer'],
            'timezone_id' => ['bail', 'required', 'integer'],
        ];
    }
}
