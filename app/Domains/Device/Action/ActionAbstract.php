<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\Device\Model\Device as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Device\Model\Device
     */
    protected ?Model $row;
}
