<?php declare(strict_types=1);

namespace App\Domains\File\Action;

use App\Domains\Shared\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\File\Model\File as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\File\Model\File
     */
    protected ?Model $row;
}
