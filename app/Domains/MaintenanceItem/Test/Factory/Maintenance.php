<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Maintenance extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\MaintenanceItem\Model\MaintenanceItem>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'date_at' => date('Y-m-d'),

            'name' => $this->faker->name,
            'workshop' => $this->faker->name,
            'description' => $this->faker->text,

            'distance' => rand(100, 1000),
            'distance_next' => rand(1000, 10000),
            'amount' => $this->faker->randomFloat(2, 100, 1000),

            'user_id' => $this->userFirstOrFactory(),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
        ];
    }
}
