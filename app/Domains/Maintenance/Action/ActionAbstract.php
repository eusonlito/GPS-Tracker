<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Maintenance\Model\Maintenance
     */
    protected ?Model $row;
}
