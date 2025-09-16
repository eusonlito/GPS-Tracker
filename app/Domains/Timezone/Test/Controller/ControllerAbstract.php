<?php declare(strict_types=1);

namespace App\Domains\Timezone\Test\Controller;

use App\Domains\CoreApp\Test\Controller\ControllerAbstract as CoreAppControllerAbstract;
use App\Domains\Timezone\Model\Timezone as Model;

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
