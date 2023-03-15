<?php declare(strict_types=1);

namespace App\Domains\UserSession\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
use App\Domains\UserSession\Model\UserSession as Model;

class UserSession extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\UserSession\Model\UserSession>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'auth' => $this->faker->email(),
            'ip' => $this->faker->ip,

            'success' => ($success = rand(1, 0)),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'user_id' => $success ? $this->userFirstOrFactory() : null,
        ];
    }
}
