<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Vehicle\Model\Vehicle as Model;

class Vehicle extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Vehicle\Model\Vehicle>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Vehicle: '.$this->faker->name(),
            'plate' => $this->faker->md5(),

            'timezone_auto' => true,
            'enabled' => true,

            'timezone_id' => $this->firstOrFactory(TimezoneModel::class),
            'user_id' => $this->userFirstOrFactory(),
        ];
    }
}
