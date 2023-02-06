<?php declare(strict_types=1);

namespace App\Domains\IpLock\Test\Feature;

use App\Domains\IpLock\Model\IpLock as Model;
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
