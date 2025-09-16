<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Test\Controller;

use App\Domains\CoreApp\Test\Controller\ControllerAbstract as CoreAppControllerAbstract;
use App\Domains\DeviceMessage\Model\DeviceMessage as Model;

abstract class ControllerAbstract extends CoreAppControllerAbstract
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }
}
