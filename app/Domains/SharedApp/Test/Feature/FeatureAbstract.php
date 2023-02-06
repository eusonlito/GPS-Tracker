<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Test\Feature;

use App\Domains\Shared\Test\Feature\FeatureAbstract as FeatureAbstractShared;
use App\Domains\User\Model\User as UserModel;

abstract class FeatureAbstract extends FeatureAbstractShared
{
    /**
     * @return string
     */
    protected function getUserClass(): string
    {
        return UserModel::class;
    }
}
