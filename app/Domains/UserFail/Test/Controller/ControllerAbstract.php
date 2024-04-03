<?php declare(strict_types=1);

namespace App\Domains\UserFail\Test\Controller;

use App\Domains\UserFail\Model\UserFail as Model;
use App\Domains\CoreApp\Test\Controller\ControllerAbstract as CoreAppControllerAbstract;

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
