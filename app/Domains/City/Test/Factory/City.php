<?php declare(strict_types=1);

namespace App\Domains\City\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
use App\Domains\City\Model\City as Model;
use App\Domains\State\Model\State as StateModel;

class City extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\City\Model\City>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),

            'point' => Model::pointFromLatitudeLongitude(42.34818, -7.9126),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'state_id' => $this->firstOrFactory(StateModel::class),
        ];
    }
}
