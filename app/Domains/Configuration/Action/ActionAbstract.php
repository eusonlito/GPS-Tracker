<?php declare(strict_types=1);

namespace App\Domains\Configuration\Action;

use App\Domains\Configuration\Model\Configuration as Model;
use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Configuration\Model\Configuration
     */
    protected ?Model $row;
}
