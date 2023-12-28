<?php declare(strict_types=1);

namespace App\Domains\City\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\City\Model\City as Model;
use App\Domains\Country\Model\Country as CountryModel;
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
            'name' => 'City: '.$this->faker->name(),
            'alias' => [$this->faker->name()],

            'point' => Model::pointFromLatitudeLongitude(42.34818, -7.9126),

            'country_id' => $this->firstOrFactory(CountryModel::class),
            'state_id' => $this->firstOrFactory(StateModel::class),
        ];
    }
}
