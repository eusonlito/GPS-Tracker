<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Test\Feature;

use App\Domains\Core\Test\Feature\FeatureAbstract as FeatureAbstractCore;
use App\Domains\User\Model\User as UserModel;

abstract class FeatureAbstract extends FeatureAbstractCore
{
    /**
     * @return string
     */
    protected function getUserClass(): string
    {
        return UserModel::class;
    }
}
