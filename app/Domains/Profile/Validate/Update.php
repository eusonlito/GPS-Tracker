<?php declare(strict_types=1);

namespace App\Domains\Profile\Validate;

use Illuminate\Validation\Rule;
use App\Domains\Shared\Validate\ValidateAbstract;

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
            'password_current' => ['bail', 'required', 'current_password'],
            'language_id' => ['bail', 'required', 'integer'],
            'preferences' => ['bail', 'required', 'array'],
            'preferences.units' => ['bail', 'required', 'array'],
            'preferences.units.decimal' => ['bail', 'required', Rule::in([',', '.'])],
            'preferences.units.distance' => ['bail', 'required', 'in:kilometer,mile'],
            'preferences.units.money' => ['bail', 'required', 'in:euro,dollar'],
            'preferences.units.thousand' => ['bail', 'required', Rule::in([',', '.'])],
            'preferences.units.volume' => ['bail', 'required', 'in:liter,gallon'],
        ];
    }
}
