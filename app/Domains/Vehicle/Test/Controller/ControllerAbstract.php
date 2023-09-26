<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Test\Controller;

use App\Domains\Vehicle\Model\Vehicle as Model;
use App\Domains\CoreApp\Test\Feature\FeatureAbstract;

abstract class ControllerAbstract extends FeatureAbstract
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }
}
