<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\Maintenance\Model\MaintenanceItem as MaintenanceItemModel;

class MaintenanceItem extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Maintenance\Model\MaintenanceItem>
     */
    protected $model = MaintenanceItemModel::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'user_id' => $this->userFirstOrFactory(),
        ];
    }
}
