<?php declare(strict_types=1);

namespace App\Domains\Device\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
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
            'name' => $this->faker->name(),
            'maker' => $this->faker->name(),
            'serial' => strval($this->faker->numberBetween()),
            'phone_number' => $this->faker->phoneNumber(),
            'password' => $this->faker->name(),

            'enabled' => true,

            'connected_at' => date('Y-m-d H:i:s'),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'user_id' => $this->userFirstOrFactory(),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
        ];
    }
}
