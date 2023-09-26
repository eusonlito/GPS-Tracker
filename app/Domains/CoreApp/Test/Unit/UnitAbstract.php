<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Test\Unit;

use App\Domains\Core\Test\Unit\UnitAbstract as UnitAbstractCore;
use App\Domains\User\Model\User as UserModel;

abstract class UnitAbstract extends UnitAbstractCore
{
    /**
     * @return string
     */
    protected function getUserClass(): string
    {
        return UserModel::class;
    }
}
