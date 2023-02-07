<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Test\Feature;

use App\Domains\SharedApp\Test\Feature\FeatureAbstract as FeatureAbstractShared;

abstract class FeatureAbstract extends FeatureAbstractShared
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return '';
    }
}
