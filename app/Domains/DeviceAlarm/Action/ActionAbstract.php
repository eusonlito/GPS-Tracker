<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    protected ?Model $row;
}
