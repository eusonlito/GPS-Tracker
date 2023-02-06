<?php declare(strict_types=1);

namespace App\Domains\Timezone\Test\Feature;

use App\Domains\Timezone\Model\Timezone as Model;
use App\Domains\Shared\Test\Feature\FeatureAbstract as FeatureAbstractShared;

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
