<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Alarm\Model\AlarmVehicle as AlarmVehicleModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class AlarmVehicle extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Alarm\Model\AlarmVehicle>
     */
    protected $model = AlarmVehicleModel::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'alarm_id' => $this->firstOrFactory(Model::class),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
        ];
    }
}
