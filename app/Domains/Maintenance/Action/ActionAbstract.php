<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\Maintenance\Model\Maintenance as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Maintenance\Model\Maintenance
     */
    protected ?Model $row;
}
