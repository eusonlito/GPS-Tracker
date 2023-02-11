<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Test\Factory;

use App\Domains\Shared\Test\Factory\FactoryAbstract as FactoryAbstractShared;
use App\Domains\User\Model\User as UserModel;

abstract class FactoryAbstract extends FactoryAbstractShared
{
    /**
     * @return string
     */
    protected function getUserClass(): string
    {
        return UserModel::class;
    }
}
