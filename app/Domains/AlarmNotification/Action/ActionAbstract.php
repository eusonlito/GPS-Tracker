<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Action;

use App\Domains\AlarmNotification\Model\AlarmNotification as Model;
use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\AlarmNotification\Model\AlarmNotification
     */
    protected ?Model $row;
}
