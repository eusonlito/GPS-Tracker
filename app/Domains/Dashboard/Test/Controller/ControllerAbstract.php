<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Test\Controller;

use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\CoreApp\Test\Feature\FeatureAbstract;

abstract class ControllerAbstract extends FeatureAbstract
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return TripModel::class;
    }
}
