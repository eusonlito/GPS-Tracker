<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\Device\Model\Device as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Device\Model\Device
     */
    protected ?Model $row;
}
