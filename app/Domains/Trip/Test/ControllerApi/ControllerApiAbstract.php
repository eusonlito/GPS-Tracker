<?php declare(strict_types=1);

namespace App\Domains\Trip\Test\ControllerApi;

use App\Domains\CoreApp\Test\ControllerApi\ControllerApiAbstract as CoreAppControllerApiAbstract;
use App\Domains\Trip\Model\Trip as Model;

abstract class ControllerApiAbstract extends CoreAppControllerApiAbstract
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }
}
