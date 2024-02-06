<?php declare(strict_types=1);

namespace App\Domains\Monitor\Test\Controller;

use App\Domains\CoreApp\Test\Feature\FeatureAbstract;

abstract class ControllerAbstract extends FeatureAbstract
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return '';
    }
}
