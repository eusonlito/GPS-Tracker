<?php declare(strict_types=1);

namespace App\Domains\Timezone\Test\ControllerApi;

use App\Domains\Timezone\Model\Timezone as Model;
use App\Domains\CoreApp\Test\ControllerApi\ControllerApiAbstract as CoreAppControllerApiAbstract;

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
