<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Action;

use App\Domains\AlarmNotification\Model\AlarmNotification as Model;
use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\AlarmNotification\Model\AlarmNotification
     */
    protected ?Model $row;
}
