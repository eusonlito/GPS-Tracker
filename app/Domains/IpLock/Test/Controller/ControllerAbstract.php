<?php declare(strict_types=1);

namespace App\Domains\IpLock\Test\Controller;

use App\Domains\IpLock\Model\IpLock as Model;
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
