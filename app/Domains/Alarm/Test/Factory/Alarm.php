<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
use App\Domains\Alarm\Model\Alarm as Model;

class Alarm extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Alarm\Model\Alarm>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type' => 'movement',
            'enabled' => true,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'user_id' => $this->userFirstOrFactory(),
        ];
    }
}
