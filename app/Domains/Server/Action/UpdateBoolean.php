<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Domains\Server\Model\Server as Model;
use App\Domains\SharedApp\Action\UpdateBoolean as UpdateBooleanSharedApp;

class UpdateBoolean extends UpdateBooleanSharedApp
{
    /**
     * @var \App\Domains\Server\Model\Server
     */
    protected Model $row;
}
