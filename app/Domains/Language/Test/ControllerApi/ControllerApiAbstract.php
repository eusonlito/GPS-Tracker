<?php declare(strict_types=1);

namespace App\Domains\Language\Test\ControllerApi;

use App\Domains\Language\Model\Language as Model;
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
