<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\Translation\Model\Translation as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Translation\Model\Translation
     */
    protected ?Model $row;
}
