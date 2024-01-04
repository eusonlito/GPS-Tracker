<?php declare(strict_types=1);

namespace App\Domains\Refuel\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\City\Model\City as CityModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Refuel extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Refuel\Model\Refuel>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'distance_total' => rand(100_000, 200_000),
            'distance' => rand(100, 1000),
            'quantity' => ($quantity = rand(10, 50)),
            'quantity_before' => 0,
            'price' => ($price = $this->faker->randomFloat(3, 1, 2)),
            'total' => round($price * $quantity, 2),

            'point' => Model::pointFromLatitudeLongitude(42.34818, -7.9126),

            'date_at' => date('Y-m-d H:i:s'),

            'city_id' => $this->firstOrFactory(CityModel::class),
            'user_id' => $this->userFirstOrFactory(),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
        ];
    }
}
