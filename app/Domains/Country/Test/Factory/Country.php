<?php declare(strict_types=1);

namespace App\Domains\Country\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\Country\Model\Country as Model;

class Country extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Country\Model\Country>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Country: '.($name = $this->faker->name),
            'code' => str_slug($name),
            'alias' => [$this->faker->name()],
        ];
    }
}
