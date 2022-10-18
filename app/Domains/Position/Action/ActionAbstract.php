<?php declare(strict_types=1);

namespace App\Domains\Position\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\Position\Model\Position as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Position\Model\Position
     */
    protected ?Model $row;
}
