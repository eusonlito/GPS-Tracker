<?php declare(strict_types=1);

namespace App\Domains\State\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
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
            'name' => $this->faker->name(),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'country_id' => $this->firstOrFactory(CountryModel::class),
        ];
    }
}
