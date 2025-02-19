<?php

declare(strict_types=1);

namespace App\Domains\Role\Action\Action;

use App\Domains\Role\Action\Model\Role\Action as Model;
use App\Domains\CoreApp\Action\UpdateRoleBoolean as UpdateBooleanCoreApp;

class UpdateRoleBoolean extends UpdateBooleanCoreApp
{
    /**
     * @var \App\Domains\Role\Action\Model\Role\Action
     */
    protected Model $row;
}
