<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Domains\Server\Model\Server as Model;
use App\Domains\CoreApp\Action\UpdateBoolean as UpdateBooleanCoreApp;

class UpdateBoolean extends UpdateBooleanCoreApp
{
    /**
     * @var \App\Domains\Server\Model\Server
     */
    protected Model $row;
}
