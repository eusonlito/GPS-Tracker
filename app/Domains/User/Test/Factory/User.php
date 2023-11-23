<?php declare(strict_types=1);

namespace App\Domains\User\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use Illuminate\Support\Facades\Hash;
use App\Domains\User\Model\User as Model;

class User extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\User\Model\User>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'User: '.$this->faker->name(),
            'email' => ($email = $this->faker->companyEmail()),
            'password' => Hash::make($email),
            'preferences' => $this->definitionPreferences(),
            'telegram' => $this->definitionTelegram(),
            'admin' => false,
            'admin_mode' => false,
            'manager' => false,
            'manager_mode' => false,
            'enabled' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'language_id' => 1,
            'timezone_id' => 343,
        ];
    }

    /**
     * @return array
     */
    protected function definitionTelegram(): array
    {
        return ['username' => 'Telegram'];
    }

    /**
     * @return array
     */
    protected function definitionPreferences(): array
    {
        return [
            'units' => $this->definitionPreferencesUnits(),
        ];
    }

    /**
     * @return array
     */
    protected function definitionPreferencesUnits(): array
    {
        return [
            'money' => 'euro',
            'volume' => 'liter',
            'decimal' => ',',
            'distance' => 'kilometer',
            'thousand' => '.',
        ];
    }
}
