<?php declare(strict_types=1);

namespace App\Domains\Trip\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Trip as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Trip extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Trip\Model\Trip>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->uuid(),
            'name' => 'Trip: '.$this->faker->name(),

            'distance' => rand(0, 1000),
            'time' => rand(0, 1000),

            'stats' => [],

            'start_at' => date('Y-m-d H:i:s'),
            'start_utc_at' => date('Y-m-d H:i:s'),
            'end_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
            'end_utc_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),

            'shared' => false,
            'shared_public' => false,

            'device_id' => $this->firstOrFactory(DeviceModel::class),
            'timezone_id' => $this->firstOrFactory(TimezoneModel::class),
            'user_id' => $this->userFirstOrFactory(),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
        ];
    }
}
