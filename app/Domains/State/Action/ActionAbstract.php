<?php declare(strict_types=1);

namespace App\Domains\State\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\State\Model\State as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\State\Model\State
     */
    protected ?Model $row;
}
