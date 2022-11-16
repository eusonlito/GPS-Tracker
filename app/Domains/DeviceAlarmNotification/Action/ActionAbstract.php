<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarmNotification\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\DeviceAlarmNotification\Model\DeviceAlarm
     */
    protected ?Model $row;
}
