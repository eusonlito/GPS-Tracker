<?php declare(strict_types=1);

namespace App\Domains\User\Test\Factory;

use App\Domains\Shared\Test\Factory\FactoryAbstract;
use Illuminate\Support\Facades\Hash;
use App\Domains\User\Model\User as Model;

class User extends FactoryAbstract
{
    /**
     * @var class-string<Illuminate\Database\Eloquent\Model>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => ($email = $this->faker->companyEmail()),
            'password' => Hash::make($email),
            'telegram' => ['username' => 'Telegram'],
            'admin' => false,
            'enabled' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'language_id' => 1,
        ];
    }
}
