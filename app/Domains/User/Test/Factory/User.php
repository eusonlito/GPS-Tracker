<?php declare(strict_types=1);

namespace App\Domains\User\Test\Factory;

use Illuminate\Database\Eloquent\Factories\Factory as FactoryEloquent;
use Illuminate\Support\Facades\Hash;
use App\Domains\User\Model\User as Model;

class User extends FactoryEloquent
{
    /**
     * @var string
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => ($email = $this->faker->unique()->companyEmail),
            'password' => Hash::make($email),
            'admin' => false,
            'enabled' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'language_id' => 1,
        ];
    }
}
