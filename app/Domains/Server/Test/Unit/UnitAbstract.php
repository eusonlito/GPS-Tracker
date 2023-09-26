<?php declare(strict_types=1);

namespace App\Domains\Server\Test\Unit;

use App\Domains\Server\Model\Server as Model;
use App\Domains\CoreApp\Test\Unit\UnitAbstract as UnitAbstractCore;

abstract class UnitAbstract extends UnitAbstractCore
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }
}
