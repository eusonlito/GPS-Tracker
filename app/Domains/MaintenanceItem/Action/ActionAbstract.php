<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\MaintenanceItem\Model\MaintenanceItem
     */
    protected ?Model $row;
}
