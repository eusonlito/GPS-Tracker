<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\DeviceMessage\Model\DeviceMessage as Model;

class DeviceMessage extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\DeviceMessage\Model\DeviceMessage>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'message' => $this->faker->text,
            'response' => $this->faker->text,

            'sent_at' => date('Y-m-d H:i:s'),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'device_id' => $this->firstOrFactory(DeviceModel::class),
        ];
    }
}
