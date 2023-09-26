<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Test\Factory;

use App\Domains\Core\Test\Factory\FactoryAbstract as FactoryAbstractCore;
use App\Domains\User\Model\User as UserModel;

abstract class FactoryAbstract extends FactoryAbstractCore
{
    /**
     * @return string
     */
    protected function getUserClass(): string
    {
        return UserModel::class;
    }
}
