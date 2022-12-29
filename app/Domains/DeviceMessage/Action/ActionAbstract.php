<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Action;

use App\Domains\DeviceMessage\Model\DeviceMessage as Model;
use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\DeviceMessage\Model\DeviceMessage
     */
    protected ?Model $row;
}
