<?php declare(strict_types=1);

namespace App\Domains\State\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\Country\Model\Country as CountryModel;
use App\Domains\State\Model\State as Model;

class State extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\State\Model\State>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'State: '.preg_replace('/[^A-Za-z\s]/', '', $this->faker->name()),
            'alias' => [preg_replace('/[^A-Za-z\s]/', '', $this->faker->name())],
            'country_id' => $this->firstOrFactory(CountryModel::class),
        ];
    }
}
