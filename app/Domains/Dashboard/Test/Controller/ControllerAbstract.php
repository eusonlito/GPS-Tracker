<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Test\Controller;

use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\CoreApp\Test\Controller\ControllerAbstract as CoreAppControllerAbstract;

abstract class ControllerAbstract extends CoreAppControllerAbstract
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return TripModel::class;
    }
}
