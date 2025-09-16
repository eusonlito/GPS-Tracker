<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\DeviceMessage\Model\DeviceMessage as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\DeviceMessage\Model\DeviceMessage
     */
    protected ?Model $row;
}
