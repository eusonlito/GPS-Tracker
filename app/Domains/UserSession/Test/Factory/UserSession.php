<?php declare(strict_types=1);

namespace App\Domains\UserSession\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
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
            'auth' => 'User Session: '.$this->faker->email(),
            'ip' => $this->faker->ipv4(),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'user_id' => $this->userFirstOrFactory(),
        ];
    }
}
