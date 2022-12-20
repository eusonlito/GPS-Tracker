<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\Vehicle\Model\Vehicle as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Vehicle\Model\Vehicle
     */
    protected ?Model $row;
}
