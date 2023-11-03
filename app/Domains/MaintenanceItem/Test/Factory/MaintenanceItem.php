<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;

class MaintenanceItem extends FactoryAbstract
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
            'name' => 'Maintenance Item: '.$this->faker->name,
            'user_id' => $this->userFirstOrFactory(),
        ];
    }
}
