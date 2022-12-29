<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;
use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Device\Model\Device
     */
    protected ?Model $row;
}
