<?php declare(strict_types=1);

namespace App\Domains\Position\Action;

use App\Domains\Position\Model\Position as Model;
use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Position\Model\Position
     */
    protected ?Model $row;
}
