<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
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
            'name' => 'Alarm: '.$this->faker->name(),
            'type' => 'movement',
            'enabled' => true,

            'user_id' => $this->userFirstOrFactory(),
        ];
    }
}
