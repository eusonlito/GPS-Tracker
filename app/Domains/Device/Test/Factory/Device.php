<?php declare(strict_types=1);

namespace App\Domains\Device\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\Device\Model\Device as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Device extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Device\Model\Device>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->uuid(),
            'name' => 'Device: '.preg_replace('/[^A-Za-z\s]/', '', $this->faker->name()),
            'model' => preg_replace('/[^A-Za-z\s]/', '', $this->faker->name()),
            'serial' => strval($this->faker->numberBetween()),
            'phone_number' => $this->faker->phoneNumber(),
            'password' => preg_replace('/[^A-Za-z\s]/', '', $this->faker->name()),

            'config' => [
                'position_filter_distance' => 0,
                'position_filter_distance_multiplier' => 0,
                'position_filter_time' => 0,
            ],

            'enabled' => true,
            'shared' => false,
            'shared_public' => false,

            'connected_at' => date('Y-m-d H:i:s'),

            'user_id' => $this->userFirstOrFactory(),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
        ];
    }
}
