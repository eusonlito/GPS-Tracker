<?php declare(strict_types=1);

namespace App\Domains\Position\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\City\Model\City as CityModel;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as Model;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Position extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Position\Model\Position>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'point' => Model::pointFromLatitudeLongitude(42.34818, -7.9126),

            'speed' => $this->faker->randomFloat(2, 10, 100),

            'direction' => rand(0, 360),
            'signal' => rand(1, 0),

            'date_at' => date('Y-m-d H:i:s'),
            'date_utc_at' => date('Y-m-d H:i:s'),

            'city_id' => $this->firstOrFactory(CityModel::class),
            'device_id' => $this->firstOrFactory(DeviceModel::class),
            'timezone_id' => $this->firstOrFactory(TimezoneModel::class),
            'trip_id' => $this->firstOrFactory(TripModel::class),
            'user_id' => $this->userFirstOrFactory(),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
        ];
    }
}
