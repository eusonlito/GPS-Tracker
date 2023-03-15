<?php declare(strict_types=1);

namespace App\Domains\Country\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
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
            'name' => ($name = $this->faker->name),
            'code' => str_slug($name),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
