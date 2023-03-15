<?php declare(strict_types=1);

namespace App\Domains\Timezone\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
use App\Domains\Timezone\Model\Timezone as Model;

class Timezone extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Timezone\Model\Timezone>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'zone' => $this->faker->name(),
            'default' => true,

            'geojson' => Model::DB()->raw(Model::emptyGeoJSON()),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
