<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Test\Feature;

use App\Domains\Vehicle\Model\Vehicle as Model;
use App\Domains\SharedApp\Test\Feature\FeatureAbstract as FeatureAbstractShared;

abstract class FeatureAbstract extends FeatureAbstractShared
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }
}
