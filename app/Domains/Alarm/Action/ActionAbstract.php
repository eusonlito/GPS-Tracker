<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\Alarm\Model\Alarm as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Alarm\Model\Alarm
     */
    protected ?Model $row;
}
