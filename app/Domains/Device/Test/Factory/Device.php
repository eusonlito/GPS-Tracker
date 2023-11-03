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
            'name' => 'Device: '.$this->faker->name(),
            'model' => $this->faker->name(),
            'serial' => strval($this->faker->numberBetween()),
            'phone_number' => $this->faker->phoneNumber(),
            'password' => $this->faker->name(),

            'enabled' => true,
            'shared' => false,
            'shared_public' => false,

            'connected_at' => date('Y-m-d H:i:s'),

            'user_id' => $this->userFirstOrFactory(),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
        ];
    }
}
