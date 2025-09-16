<?php declare(strict_types=1);

namespace App\Domains\Device\Test\ControllerApi;

use App\Domains\CoreApp\Test\ControllerApi\ControllerApiAbstract as CoreAppControllerApiAbstract;
use App\Domains\Device\Model\Device as Model;

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
