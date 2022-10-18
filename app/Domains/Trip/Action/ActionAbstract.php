<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\Trip\Model\Trip as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Trip\Model\Trip
     */
    protected ?Model $row;
}
