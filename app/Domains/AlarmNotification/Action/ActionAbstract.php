<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\AlarmNotification\Model\AlarmNotification as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\AlarmNotification\Model\Alarm
     */
    protected ?Model $row;
}
