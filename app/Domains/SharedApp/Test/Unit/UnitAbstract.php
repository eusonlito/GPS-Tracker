<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Test\Unit;

use App\Domains\Shared\Test\Unit\UnitAbstract as UnitAbstractShared;
use App\Domains\User\Model\User as UserModel;

abstract class UnitAbstract extends UnitAbstractShared
{
    /**
     * @return string
     */
    protected function getUserClass(): string
    {
        return UserModel::class;
    }
}
