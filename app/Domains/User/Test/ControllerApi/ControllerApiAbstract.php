<?php declare(strict_types=1);

namespace App\Domains\User\Test\ControllerApi;

use App\Domains\CoreApp\Test\ControllerApi\ControllerApiAbstract as CoreAppControllerApiAbstract;
use App\Domains\User\Model\User as Model;

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
